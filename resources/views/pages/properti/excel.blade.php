
<table style="table-layout: fixed; width:100%">
    <thead>
    <tr>
        <th colspan="16" style="text-align: center"><b>Daftar Tagihan IPKL</b></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #000000; width: 25px;">No</td>
            <td style="border: 1px solid #000000; width: 120px">Pemilik</td>
            <td style="border: 1px solid #000000; width: 75px;">Cluster</td>
            <td style="border: 1px solid #000000; width: 100px">No Rumah</td>
            <td style="border: 1px solid #000000; width: 100px">No Listrik</td>
            <td style="border: 1px solid #000000; width: 100px">No Pam bsd</td>
            <td style="border: 1px solid #000000; width: 100px">penghuni</td>
            <td style="border: 1px solid #000000; width: 100px">Alamat</td>
            <td style="border: 1px solid #000000; width: 100px">RT</td>
            <td style="border: 1px solid #000000; width: 100px">RW</td>
            <td style="border: 1px solid #000000; width: 100px">Jumlah Lantai</td>
            <td style="border: 1px solid #000000; width: 100px">Jumlah Kamar</td>
            <td style="border: 1px solid #000000; width: 100px">Luas Tanah</td>
            <td style="border: 1px solid #000000; width: 100px">Luas Bangunan</td>
            <td style="border: 1px solid #000000; width: 100px">Tarif IPKL</td>
            <td style="border: 1px solid #000000; width: 100px">Status</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @foreach($properti as $index => $p)
        <tr class="body">
            <td style="border: 1px solid #000000; text-align: center; vertical-align: top;">{{ $index }}</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">{{ $p->pemilik->name }}</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">{{ $p->cluster->name }}</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->no_rumah }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->no_listrik }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->no_pam_bsd }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">{{ $p->penghuni->name }}</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">{{ $p->alamat }},<br> {{$p->kelurahan}},<br> {{$p->kecamatan}},<br> {{$p->kabupaten}},<br> {{$p->provinsi}}</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->RT }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->RW }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->lantai }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->jumlah_kamar }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->luas_tanah }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">"{{ $p->luas_bangunan }}"</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">Rp {{ $p->tarif_ipkl }}</td>
            <td style="border: 1px solid #000000; text-align: left; vertical-align: top">{{ $p->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
