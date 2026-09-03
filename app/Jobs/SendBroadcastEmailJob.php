<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Exception;

class SendBroadcastEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchId;
    protected $contactIds;
    protected $subject;
    protected $messageContent;
    protected $filePath;
    protected $fileName;

    public function __construct(string $batchId, array $contactIds, string $subject, string $messageContent, ?string $filePath, ?string $fileName)
    {
        $this->batchId = $batchId;
        $this->contactIds = $contactIds;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    public function handle(): void
    {
        $total = count($this->contactIds);
        $processed = 0;

        // Inisialisasi Cache Tracking
        Cache::put("broadcast_progress_{$this->batchId}", [
            'processed' => 0,
            'total'     => $total,
            'percentage' => 0,
            'status'    => 'running'
        ], 3600);

        DB::table('b_master_contact')
            ->whereIn('id_b_master_contact', $this->contactIds)
            ->chunkById(50, function ($contacts) use ($total, &$processed) {
                foreach ($contacts as $contact) {
                    try {
                        Mail::mailer('smtp_second')->raw($this->messageContent, function ($mail) use ($contact) {
                            $mail->to($contact->b_master_contact_email, $contact->b_master_contact_name)
                                ->subject($this->subject);

                            if ($this->filePath && Storage::exists($this->filePath)) {
                                $mail->attach(storage_path('app/' . $this->filePath));
                            }
                        });

                        DB::table('b_email_histories')->insert([
                            'recipient_email' => $contact->b_master_contact_email,
                            'recipient_name'  => $contact->b_master_contact_name,
                            'subject'          => $this->subject,
                            'message'          => $this->messageContent,
                            'attachment'       => $this->fileName,
                            'status'           => 'success',
                            'error_message'    => null,
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ]);
                    } catch (Exception $e) {
                        DB::table('b_email_histories')->insert([
                            'recipient_email' => $contact->b_master_contact_email,
                            'recipient_name'  => $contact->b_master_contact_name,
                            'subject'          => $this->subject,
                            'message'          => $this->messageContent,
                            'attachment'       => $this->fileName,
                            'status'           => 'failed',
                            'error_message'    => $e->getMessage(),
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ]);
                    }

                    $processed++;
                    $percentage = round(($processed / $total) * 100);

                    // Update Cache untuk Monitoring Real-Time
                    Cache::put("broadcast_progress_{$this->batchId}", [
                        'processed' => $processed,
                        'total'     => $total,
                        'percentage' => $percentage,
                        'status'    => ($processed >= $total) ? 'completed' : 'running'
                    ], 3600);
                }
            }, 'id_b_master_contact');
    }
}
