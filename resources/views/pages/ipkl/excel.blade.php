
<table>
    <thead>
    <tr>
        <th style="border: 1px solid #000000">No</th>
        <th style="border: 1px solid #000000">Cluster</th>
        <th style="border: 1px solid #000000">No Rumah</th>
        <th style="border: 1px solid #000000" colspan="2">Periode Pembayaran</th>
        <th style="border: 1px solid #000000" colspan="2">Jumlah Pembayaran</th>
        <th style="border: 1px solid #000000">Type</th>
        <th style="border: 1px solid #000000" colspan="2">Status Tagihan</th>
    </tr>
    </thead>
    <tbody>
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
            <td style="border: 1px solid #000000">{{ $index }}</td>
            <td style="border: 1px solid #000000">{{ $t->cluster->name }}</td>
            <td style="border: 1px solid #000000">{{ $t->nomer->no_rumah }}</td>
            <td style="border: 1px solid #000000" colspan="2">{{ $t->periode_pembayaran }}</td>
            <td style="border: 1px solid #000000" colspan="2">{{ $t->jumlah_pembayaran }}</td>
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
