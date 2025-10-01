<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $report->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }
        
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            color: #333;
        }
        
        .subtitle {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        
        .meta-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .meta-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .content {
            margin: 20px 0;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        
        .summary-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .summary-label {
            font-size: 12px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .chart-placeholder {
            background: #f8f9fa;
            border: 2px dashed #ddd;
            padding: 40px;
            text-align: center;
            color: #666;
            margin: 20px 0;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $report->title }}</div>
        <div class="subtitle">Laporan BAN-PT - {{ ucfirst(str_replace('_', ' ', $report->type)) }}</div>
        <div class="subtitle">{{ $report->tracer_study_session->display_name ?? 'Semua Sesi' }}</div>
    </div>

    <div class="meta-info">
        <div class="meta-row">
            <strong>Tanggal Dibuat:</strong>
            <span>{{ $report->created_at->format('d F Y H:i') }}</span>
        </div>
        <div class="meta-row">
            <strong>Format:</strong>
            <span>{{ strtoupper($report->format) }}</span>
        </div>
        <div class="meta-row">
            <strong>Status:</strong>
            <span>{{ $report->status_label }}</span>
        </div>
        @if($report->parameters)
            <div class="meta-row">
                <strong>Filter:</strong>
                <span>
                    @if(isset($report->parameters['graduation_years']))
                        Tahun Lulus: {{ implode(', ', $report->parameters['graduation_years']) }}
                    @endif
                    @if(isset($report->parameters['programs']))
                        | Program: {{ count($report->parameters['programs']) }} program
                    @endif
                </span>
            </div>
        @endif
    </div>

    <div class="content">
        @if(isset($summary))
            <div class="section">
                <div class="section-title">Ringkasan Eksekutif</div>
                <div class="summary-grid">
                    @foreach($summary as $key => $value)
                        <div class="summary-card">
                            <div class="summary-value">{{ $value }}</div>
                            <div class="summary-label">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(isset($data) && !empty($data))
            <div class="section">
                <div class="section-title">Data Laporan</div>
                
                @if($report->type === 'employment_statistics')
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Program Studi</th>
                                <th>Total Alumni</th>
                                <th>Bekerja</th>
                                <th>Tidak Bekerja</th>
                                <th>Persentase Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['program'] ?? '-' }}</td>
                                    <td>{{ $row['total_alumni'] ?? 0 }}</td>
                                    <td>{{ $row['bekerja'] ?? 0 }}</td>
                                    <td>{{ $row['tidak_bekerja'] ?? 0 }}</td>
                                    <td>{{ $row['persentase_kerja'] ?? '0%' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                @elseif($report->type === 'waiting_period')
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Program Studi</th>
                                <th>Rata-rata Masa Tunggu</th>
                                <th>Median</th>
                                <th>Total Alumni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['program'] ?? '-' }}</td>
                                    <td>{{ $row['avg_waiting_period'] ?? 0 }} bulan</td>
                                    <td>{{ $row['median_waiting_period'] ?? 0 }} bulan</td>
                                    <td>{{ $row['total_alumni'] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                @else
                    {{-- Generic table for other report types --}}
                    @if(!empty($data))
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @foreach(array_keys($data[0]) as $header)
                                        <th>{{ ucwords(str_replace('_', ' ', $header)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        @foreach($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif
            </div>
        @endif

        @if($report->parameters['include_charts'] ?? false)
            <div class="section">
                <div class="section-title">Visualisasi Data</div>
                <div class="chart-placeholder">
                    [Grafik dan Chart akan ditampilkan di sini]<br>
                    Fitur visualisasi data tersedia dalam versi interaktif
                </div>
            </div>
        @endif

        @if($report->parameters['include_raw_data'] ?? false)
            <div class="page-break"></div>
            <div class="section">
                <div class="section-title">Data Mentah (Raw Data)</div>
                <p style="font-style: italic; color: #666;">
                    Data mentah lengkap tersedia dalam format Excel untuk analisis lebih lanjut.
                </p>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>
            Laporan ini dibuat secara otomatis oleh Sistem Tracer Study<br>
            Tanggal: {{ now()->format('d F Y H:i:s') }} | 
            Halaman dibuat untuk: {{ $report->title }}
        </p>
    </div>
</body>
</html>
