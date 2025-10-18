<div class="table-responsive scrollbar pt-3">
    <table class="table border" border="1">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Deskripsi</th>
                <th class="text-end" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $datas)
                <tr>
                    <td>{{ $datas->diag_poli_gigi_umum_name }}</td>
                    <td>{{ $datas->diag_poli_gigi_umum_desc }}</td>
                    <td class="text-end">
                        <div>
                            <button class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Edit"><span class="text-500 fas fa-edit"></span></button>
                            <button class="btn p-0 ms-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
