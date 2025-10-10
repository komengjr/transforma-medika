 <div class="tab-content">
     <table id="data-v3s" class="table table-striped nowrap" style="width:100%">
         <thead class="bg-200 text-700">
             <tr>
                 <th>No</th>
                 <th>Pemeriksaan</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             @php
                 $no = 1;
             @endphp
             @foreach ($data as $item)
                 <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ $item->master_pemeriksaan_name }}</td>
                     <td>
                         <button class="btn btn-falcon-primary" id="button-hapus-pemeriksaan"
                             data-id="{{ $item->id_mou_agreement_sub }}" data-code="{{$item->mou_agreement_code}}"><span class="fas fa-trash"></span> Hapus</button>
                     </td>
                 </tr>
             @endforeach
         </tbody>
     </table>
 </div>
 <script>
     new DataTable('#data-v3s', {
         responsive: true
     });
 </script>
