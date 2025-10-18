<div>
    <label for="inputLastName1" class="form-label">Kota</label>
    <div class="input-group"> <span class="input-group-text"><i class="fas fa-city"></i></span>
        <select name="data_city" id="data_city" class="form-control form-control-lg single-select">
            <option value="">Pilih Kota</option>
            @foreach ($city as $citys)
                <option value="{{$citys->M_CityID}}">{{$citys->M_CityName}}</option>
            @endforeach
        </select>
    </div>
</div>
