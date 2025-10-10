   <table id="example-pem" class="table table-striped border" style="width:100%">
       <thead class="bg-200 text-700">
           <tr>
               <th>No</th>
               <th>Nama Pemeriksaan</th>
               <th>Harga</th>
               <th>Action</th>
           </tr>
       </thead>
       <tbody class="fs--1">
           @php
           $no = 1;
           @endphp
           @foreach ($data as $datas)
           <tr>
               <td>{{ $no++ }}</td>
               <td>{{ $datas->t_pemeriksaan_list_name }}</td>
               <td>@currency($datas->p_sales_data_price)</td>
               <td>
                   <button class="btn btn-falcon-warning btn-sm" id="button-pilih-data-pemeriksaan-pasien" data-code="{{ $datas->p_sales_data_code}}"  >Pilih</button>
               </td>
           </tr>
           @endforeach
       </tbody>
   </table>
   <script>
       new DataTable('#example-pem', {
           responsive: true
       });
   </script>
