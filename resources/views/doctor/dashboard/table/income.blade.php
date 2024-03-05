<x-card-container>
    <table id="incomeReportTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Cabang</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Total Fee Layanan</th>
                <th>Total Fee Addon</th>
                <th>Total Fee</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data['transaction_code'] }}</td>
                    <td>{{ $data['transaction_date'] }}</td>
                    <td>{{ $data['branch'] }}</td>
                    <td>{{ $data['patient'] }}</td>
                    <td>{{ $data['doctor'] }}</td>
                    <td>{{ number_format($data['total_fee_treatment'], 0, ',', '.') }}</td>
                    <td>{{ number_format($data['total_fee_addon'], 0, ',', '.') }}</td>
                    <td>{{ number_format($data['total_fee'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">Total:</th>
                <th>
                    {{ number_format($results->sum('total_fee_treatment'), 0, ',', '.') }}
                </th>
                <th>
                    {{ number_format($results->sum('total_fee_addon'), 0, ',', '.') }}
                </th>
                <th>
                    {{ number_format($results->sum('total_fee'), 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>
</x-card-container>
