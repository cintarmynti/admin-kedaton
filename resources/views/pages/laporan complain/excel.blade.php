
<table>
    <thead>
    <tr>
        <th colspan="10" style="text-align: center"><b>Daftar Complain</b></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #000000; width: 25px;">No</td>
            <td style="border: 1px solid #000000">Nama</td>
            <td style="border: 1px solid #000000; width: 75px;">Alamat</td>
            <td style="border: 1px solid #000000" colspan="2">Catatan</td>
            <td style="border: 1px solid #000000" colspan="2">tanggal</td>
            <td style="border: 1px solid #000000" colspan="2">Status Tagihan</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td></td>
            <td colspan="2"></td>
        </tr>
    @foreach($complain as $index => $t)
        <tr class="body">
            <td style="border: 1px solid #000000; text-align: center;">{{ $index }}</td>
            <td style="border: 1px solid #000000">{{ $t->user->name }}</td>
            <td style="border: 1px solid #000000; text-align: left;">{{ $t->alamat }}</td>
            <td style="border: 1px solid #000000" colspan="2">{{ $t->catatan }}</td>
            <td style="border: 1px solid #000000" colspan="2">{{ $t->created_at }}</td>
            <td style="border: 1px solid #000000" colspan="2">
            @if ($t->status == 'diajukan')
                diajukan
            @elseif ($t->status == 'diproses')
                diproses
            @elseif ($t->status == 'selesai')
                selesai
            @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
