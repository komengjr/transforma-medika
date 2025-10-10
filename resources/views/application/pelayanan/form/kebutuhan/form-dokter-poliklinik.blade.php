 <div class="card my-3">
     <div class="card-body d-flex justify-content-between">
         <div>

             <span class="mx-1 mx-sm-2 text-danger">|</span>
             <span>{{$dokter->master_doctor_title_f}} {{$dokter->master_doctor_name}} {{$dokter->master_doctor_title_e}} - {{$tgl}}</span>
         </div>
         <div class="d-flex">

             <div class="dropdown font-sans-serif">
                 <button class="btn btn-success btn-sm dropdown-toggle dropdown-caret-none ms-2" type="button"
                     id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true"
                     aria-expanded="false"><span class="far fa-save"></span> Daftar Poli</button>
                 <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-settings">
                     <a class="dropdown-item" href="#!" id="button-fix-print-registrasi-poli" data-code="{{$dokter->m_doctor_poli_code}}" data-layanan="{{$dokter->t_layanan_cat_code}}" data-date="{{$tgl}}">Registrasi</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="#!">Send feedback</a>
                     <a class="dropdown-item" href="#!">Help</a>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="tab-content ">
     <table id="data-dokter" class="table table-striped nowrap border" style="width:100%">
         <thead class="bg-primary text-white">
             <tr>
                 <th>No</th>
                 <th>Antrian</th>
                 <th>Nama Pasien</th>
                 <th>Status Pasien</th>
             </tr>
         </thead>
         <tbody>
             @php
                 $no = 1;
             @endphp

         </tbody>
     </table>
 </div>
 <script>
     new DataTable('#data-dokter', {
         responsive: true
     });
 </script>
