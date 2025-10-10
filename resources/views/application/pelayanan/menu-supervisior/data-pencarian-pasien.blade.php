 <table id="example" class="table table-striped nowrap" style="width:100%">
     <thead class="bg-200 text-700">
         <tr>
             <th>No</th>
             <th>No. Reg</th>
             <th>Nama Pasien</th>
             <th>Tempat, Tanggal Lahir</th>
             <th>Kategori Pasien</th>
             <th>Layanan</th>
             <th>Tanggal Registrasi</th>
             <th>Action</th>
         </tr>
     </thead>
     <tbody class="fs--2">
         @php
         $no = 1;
         @endphp
         @foreach ($data as $datas)
         @php
         $user = DB::table('user_mains')->select('fullname')->where('userid',$datas->d_reg_order_user)->first();
         @endphp
         <tr>
             <td>{{ $no++ }}</td>
             <td>
                 {{ $datas->d_reg_order_code }} <br>
                 @if ($user)
                 <span class="badge bg-primary">{{$user->fullname}}</span>
                 @else
                 <span class="badge bg-danger">Unknown</span>
                 @endif
             </td>
             <td>{{ $datas->master_patient_name }}</td>
             <td>{{ $datas->master_patient_tempat_lahir }}, {{ $datas->master_patient_tgl_lahir }}</td>
             <td class="text-info">{{ $datas->t_pasien_cat_name }}</td>
             <td>
                 @php
                 $layanan = DB::table('d_reg_order_list')->where('d_reg_order_code',$datas->d_reg_order_code)
                 ->join('t_layanan_cat','t_layanan_cat.t_layanan_cat_code','=','d_reg_order_list.t_layanan_cat_code')
                 ->get();
                 @endphp
                 @foreach ($layanan as $layanans)
                 <li><strong>{{$layanans->d_reg_order_list_code }}</strong> <br> <span class="text-warning">{{$layanans->t_layanan_cat_name}}</span></li>
                 @endforeach
             </td>
             <td>{{ $datas->d_reg_order_date }}</td>
             <td>
                 <div class="btn-group" role="group">
                     <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                         type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="false"><span class="fas fa-align-left me-1"
                             data-fa-transform="shrink-3"></span>Menu</button>
                     <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                         <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                             id="button-data-barang-cabang" data-code="123">
                             <span class="fab fa-elementor"></span>
                             Detail Pasien
                         </button>
                     </div>
                 </div>
             </td>
         </tr>
         @endforeach
     </tbody>
 </table>
 <script>
     new DataTable('#example', {
         responsive: true
     });
 </script>
