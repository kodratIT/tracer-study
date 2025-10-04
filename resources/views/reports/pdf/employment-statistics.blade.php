<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #1f2937;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #10b981;
        }
        
        .header h1 {
            font-size: 18px;
            color: #10b981;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14px;
            color: #6b7280;
            font-weight: normal;
        }
        
        .header .meta {
            margin-top: 10px;
            font-size: 10px;
            color: #9ca3af;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .summary-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }
        
        .summary-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 5px;
        }
        
        .summary-card .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }
        
        .summary-card.success .value { color: #10b981; }
        .summary-card.warning .value { color: #f59e0b; }
        .summary-card.info .value { color: #3b82f6; }
        .summary-card.danger .value { color: #ef4444; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table th {
            background: #10b981;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }
        
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        table tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>💼 {{ $title }}</h1>
        @if($session)
            <h2>{{ $session->title ?? "Tracer Study {$session->year}" }}</h2>
        @endif
        <div class="meta">
            Generated: {{ $generated_at }} | Format: PDF
        </div>
    </div>

    <!-- Summary Section -->
    <div class="section">
        <div class="section-title">📊 Ringkasan Ketenagakerjaan</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="value">{{ number_format($summary['total_alumni']) }}</div>
                <div class="label">Total Alumni</div>
            </div>
            <div class="summary-card success">
                <div class="value">{{ number_format($summary['employed']) }}</div>
                <div class="label">Bekerja</div>
            </div>
            <div class="summary-card warning">
                <div class="value">{{ number_format($summary['entrepreneur']) }}</div>
                <div class="label">Wiraswasta</div>
            </div>
            <div class="summary-card info">
                <div class="value">{{ number_format($summary['studying']) }}</div>
                <div class="label">Studi Lanjut</div>
            </div>
        </div>
        
        <div class="summary-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="summary-card danger">
                <div class="value">{{ number_format($summary['unemployed']) }}</div>
                <div class="label">Tidak Bekerja</div>
            </div>
            <div class="summary-card">
                <div class="value">{{ number_format($summary['no_data']) }}</div>
                <div class="label">Tidak Ada Data</div>
            </div>
            <div class="summary-card success">
                <div class="value">{{ number_format($summary['employment_rate'], 1) }}%</div>
                <div class="label">Employment Rate</div>
            </div>
        </div>
    </div>

    <!-- By Program Section -->
    <div class="section">
        <div class="section-title">📚 Statistik per Program Studi</div>
        <table>
            <thead>
                <tr>
                    <th>Program</th>
                    <th style="text-align: center;">Total</th>
                    <th style="text-align: center;">Bekerja</th>
                    <th style="text-align: center;">Wiraswasta</th>
                    <th style="text-align: center;">Studi</th>
                    <th style="text-align: center;">Tidak Bekerja</th>
                    <th style="text-align: center;">Employment Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($by_program as $program)
                <tr>
                    <td>{{ $program['program_name'] }}</td>
                    <td style="text-align: center;">{{ $program['total_alumni'] }}</td>
                    <td style="text-align: center;">{{ $program['employed'] }}</td>
                    <td style="text-align: center;">{{ $program['entrepreneur'] }}</td>
                    <td style="text-align: center;">{{ $program['studying'] }}</td>
                    <td style="text-align: center;">{{ $program['unemployed'] }}</td>
                    <td style="text-align: center;"><strong>{{ number_format($program['employment_rate'], 1) }}%</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- By Industry Section -->
    <div class="section">
        <div class="section-title">🏢 Distribusi per Industri</div>
        <table>
            <thead>
                <tr>
                    <th>Jenis Industri</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                    <th style="width: 40%;">Progress</th>
                </tr>
            </thead>
            <tbody>
                @forelse($by_industry as $industry)
                <tr>
                    <td>{{ $industry['industry_type'] }}</td>
                    <td style="text-align: center;">{{ $industry['count'] }}</td>
                    <td style="text-align: center;">{{ number_format($industry['percentage'], 1) }}%</td>
                    <td>
                        <div style="background: #e5e7eb; border-radius: 4px; overflow: hidden; height: 12px;">
                            <div style="background: #10b981; width: {{ $industry['percentage'] }}%; height: 100%;"></div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- By Job Level Section -->
    <div class="section">
        <div class="section-title">📊 Distribusi per Level Jabatan</div>
        <table>
            <thead>
                <tr>
                    <th>Level Jabatan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                    <th style="width: 40%;">Progress</th>
                </tr>
            </thead>
            <tbody>
                @forelse($by_job_level as $level)
                <tr>
                    <td>{{ $level['label'] }}</td>
                    <td style="text-align: center;">{{ $level['count'] }}</td>
                    <td style="text-align: center;">{{ number_format($level['percentage'], 1) }}%</td>
                    <td>
                        <div style="background: #e5e7eb; border-radius: 4px; overflow: hidden; height: 12px;">
                            <div style="background: #3b82f6; width: {{ $level['percentage'] }}%; height: 100%;"></div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- By Contract Type Section -->
    <div class="section">
        <div class="section-title">📝 Distribusi per Jenis Kontrak</div>
        <table>
            <thead>
                <tr>
                    <th>Jenis Kontrak</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                    <th style="width: 40%;">Progress</th>
                </tr>
            </thead>
            <tbody>
                @forelse($by_contract_type as $contract)
                <tr>
                    <td>{{ $contract['label'] }}</td>
                    <td style="text-align: center;">{{ $contract['count'] }}</td>
                    <td style="text-align: center;">{{ number_format($contract['percentage'], 1) }}%</td>
                    <td>
                        <div style="background: #e5e7eb; border-radius: 4px; overflow: hidden; height: 12px;">
                            <div style="background: #f59e0b; width: {{ $contract['percentage'] }}%; height: 100%;"></div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini di-generate secara otomatis oleh Sistem Tracer Study</p>
        <p>{{ $generated_at }}</p>
    </div>
</body>
</html>
