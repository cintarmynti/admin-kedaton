
<table>
    <thead>
    <tr>
        <th colspan="10" style="text-align: center"><b>Daftar Tagihan IPKL</b></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #000000; width: 25px;">No</td>
            <td style="border: 1px solid #000000">Cluster</td>
            <td style="border: 1px solid #000000; width: 75px;">No Rumah</td>
            <td style="border: 1px solid #000000" colspan="2">Periode Pembayaran</td>
            <td style="border: 1px solid #000000" colspan="2">Jumlah Pembayaran</td>
            <td style="border: 1px solid #000000">Type</td>
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
    @foreach($pembayaran as $index => $t)
        <tr class="body">
            <td style="border: 1px solid #000000; text-align: center;">{{ $index+1 }}</td>
            <td style="border: 1px solid #000000">{{ $t->cluster->name }}</td>
            <td style="border: 1px solid #000000; text-align: left;">{{ $t->nomer->no_rumah }}</td>
            <td style="border: 1px solid #000000" colspan="2">{{ $t->periode_pembayaran }}</td>
            <td style="border: 1px solid #000000" colspan="2">Rp {{ $t->jumlah_pembayaran }}</td>
            <td style="border: 1px solid #000000">{{ $t->type->name }}</td>
            <td style="border: 1px solid #000000" colspan="2">@if ($t->status == 1)
                Belum dibayar
            @elseif ($t->status == 2)
                Pending
            @elseif ($t->status == 3)
                Sudah dibayar
            @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
