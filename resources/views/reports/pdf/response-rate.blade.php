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
            border-bottom: 3px solid #4f46e5;
        }
        
        .header h1 {
            font-size: 18px;
            color: #4f46e5;
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
            color: #4f46e5;
            margin-bottom: 5px;
        }
        
        .summary-card .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }
        
        .summary-card.success .value { color: #10b981; }
        .summary-card.warning .value { color: #f59e0b; }
        .summary-card.danger .value { color: #ef4444; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table th {
            background: #4f46e5;
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
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-gray { background: #f3f4f6; color: #374151; }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📈 {{ $title }}</h1>
        @if($session)
            <h2>{{ $session->title ?? "Tracer Study {$session->year}" }}</h2>
        @endif
        <div class="meta">
            Generated: {{ $generated_at }} | Format: PDF
        </div>
    </div>

    <!-- Summary Section -->
    <div class="section">
        <div class="section-title">📊 Ringkasan</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="value">{{ number_format($summary['total_alumni']) }}</div>
                <div class="label">Total Alumni</div>
            </div>
            <div class="summary-card success">
                <div class="value">{{ number_format($summary['total_responded']) }}</div>
                <div class="label">Sudah Respon</div>
            </div>
            <div class="summary-card success">
                <div class="value">{{ number_format($summary['total_completed']) }}</div>
                <div class="label">Selesai</div>
            </div>
            <div class="summary-card">
                <div class="value">{{ number_format($summary['response_rate'], 1) }}%</div>
                <div class="label">Response Rate</div>
            </div>
        </div>
        
        <div class="summary-grid">
            <div class="summary-card warning">
                <div class="value">{{ number_format($summary['total_partial']) }}</div>
                <div class="label">Dalam Proses</div>
            </div>
            <div class="summary-card">
                <div class="value">{{ number_format($summary['total_draft']) }}</div>
                <div class="label">Draft</div>
            </div>
            <div class="summary-card danger">
                <div class="value">{{ number_format($summary['total_not_started']) }}</div>
                <div class="label">Belum Mulai</div>
            </div>
            <div class="summary-card success">
                <div class="value">{{ number_format($summary['completion_rate'], 1) }}%</div>
                <div class="label">Completion Rate</div>
            </div>
        </div>
    </div>

    <!-- By Program Section -->
    <div class="section">
        <div class="section-title">📚 Response Rate per Program Studi</div>
        <table>
            <thead>
                <tr>
                    <th>Program Studi</th>
                    <th>Department</th>
                    <th style="text-align: center;">Total Alumni</th>
                    <th style="text-align: center;">Respon</th>
                    <th style="text-align: center;">Selesai</th>
                    <th style="text-align: center;">Response Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($by_program as $program)
                <tr>
                    <td>{{ $program['program_name'] }}</td>
                    <td>{{ $program['department_name'] }}</td>
                    <td style="text-align: center;">{{ $program['total_alumni'] }}</td>
                    <td style="text-align: center;">{{ $program['total_responses'] }}</td>
                    <td style="text-align: center;">{{ $program['total_completed'] }}</td>
                    <td style="text-align: center;">
                        <strong>{{ number_format($program['response_rate'], 1) }}%</strong>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- By Graduation Year Section -->
    <div class="section">
        <div class="section-title">📅 Response Rate per Tahun Lulus</div>
        <table>
            <thead>
                <tr>
                    <th>Tahun Lulus</th>
                    <th style="text-align: center;">Total Alumni</th>
                    <th style="text-align: center;">Respon</th>
                    <th style="text-align: center;">Selesai</th>
                    <th style="text-align: center;">Response Rate</th>
                    <th style="text-align: center;">Completion Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($by_graduation_year as $year)
                <tr>
                    <td><strong>{{ $year['graduation_year'] }}</strong></td>
                    <td style="text-align: center;">{{ $year['total_alumni'] }}</td>
                    <td style="text-align: center;">{{ $year['total_responses'] }}</td>
                    <td style="text-align: center;">{{ $year['total_completed'] }}</td>
                    <td style="text-align: center;">{{ number_format($year['response_rate'], 1) }}%</td>
                    <td style="text-align: center;">{{ number_format($year['completion_rate'], 1) }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- By Status Section -->
    <div class="section">
        <div class="section-title">📊 Distribusi Status Respons</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                    <th style="width: 40%;">Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($by_status as $status)
                <tr>
                    <td>{{ $status['label'] }}</td>
                    <td style="text-align: center;">{{ $status['count'] }}</td>
                    <td style="text-align: center;">{{ number_format($status['percentage'], 1) }}%</td>
                    <td>
                        <div style="background: #e5e7eb; border-radius: 4px; overflow: hidden; height: 12px;">
                            <div style="background: {{ $status['color'] }}; width: {{ $status['percentage'] }}%; height: 100%;"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Details Section -->
    <div class="section">
        <div class="section-title">📋 Detail Alumni</div>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Program</th>
                    <th style="text-align: center;">Angkatan</th>
                    <th style="text-align: center;">Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($details as $alumni)
                <tr>
                    <td>{{ $alumni['student_id'] }}</td>
                    <td>{{ $alumni['name'] }}</td>
                    <td>{{ $alumni['program_name'] }}</td>
                    <td style="text-align: center;">{{ $alumni['graduation_year'] }}</td>
                    <td style="text-align: center;">
                        @if($alumni['status'] === 'completed')
                            <span class="badge badge-success">Selesai</span>
                        @elseif($alumni['status'] === 'partial')
                            <span class="badge badge-warning">Proses</span>
                        @elseif($alumni['status'] === 'draft')
                            <span class="badge badge-gray">Draft</span>
                        @else
                            <span class="badge badge-danger">Belum</span>
                        @endif
                    </td>
                    <td>{{ $alumni['submitted_at'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
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
