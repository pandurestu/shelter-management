<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Officer;
use App\Models\Schedule;
use App\Models\Shelter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $reportType = $request->get('type', 'schedule'); // schedule, officer, shelter
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $shelterId = $request->get('shelter_id', 'all');
        $shift = $request->get('shift', 'all');

        $shelters = Shelter::orderBy('name')->get();

        $data = [];

        if ($reportType === 'schedule') {
            $query = Schedule::with(['shelter', 'officer'])
                ->whereBetween('date', [$startDate, $endDate]);

            if ($shelterId !== 'all') {
                $query->where('shelter_id', $shelterId);
            }

            if ($shift !== 'all') {
                $query->where('shift', $shift);
            }

            $data = $query->orderBy('date', 'asc')->orderBy('start_time', 'asc')->get();
        } elseif ($reportType === 'officer') {
            $query = Officer::with(['shelter'])->withCount(['schedules' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }]);

            if ($shelterId !== 'all') {
                $query->where('shelter_id', $shelterId);
            }

            $data = $query->orderBy('name', 'asc')->get();
        } elseif ($reportType === 'shelter') {
            $query = Shelter::withCount(['officers', 'schedules' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }]);

            if ($shelterId !== 'all') {
                $query->where('id', $shelterId);
            }

            $data = $query->orderBy('code', 'asc')->get();
        }

        return view('admin.reports.index', compact(
            'reportType',
            'startDate',
            'endDate',
            'shelterId',
            'shift',
            'shelters',
            'data'
        ));
    }

    public function print(Request $request): View
    {
        $reportType = $request->get('type', 'schedule');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $shelterId = $request->get('shelter_id', 'all');
        $shift = $request->get('shift', 'all');

        $shelter = $shelterId !== 'all' ? Shelter::find($shelterId) : null;

        $data = $this->fetchReportData($reportType, $startDate, $endDate, $shelterId, $shift);

        ActivityLog::log(
            'EXPORT',
            'Laporan',
            "Mencetak Laporan {$reportType} periode {$startDate} s/d {$endDate}."
        );

        return view('admin.reports.print', compact('reportType', 'startDate', 'endDate', 'shelter', 'shift', 'data'));
    }

    public function exportExcel(Request $request): Response
    {
        $reportType = $request->get('type', 'schedule');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $shelterId = $request->get('shelter_id', 'all');
        $shift = $request->get('shift', 'all');

        $data = $this->fetchReportData($reportType, $startDate, $endDate, $shelterId, $shift);

        $filename = "Laporan_{$reportType}_".date('Ymd_His').'.xls';

        $titleMap = [
            'schedule' => 'LAPORAN REKAPITULASI JADWAL PLOTTING PENJAGAAN',
            'officer' => 'LAPORAN DATA PERSONEL PETUGAS LAPANGAN',
            'shelter' => 'LAPORAN MASTER DATA POSKO SHELTER TERPANTAU',
        ];

        $reportTitle = $titleMap[$reportType] ?? 'LAPORAN REKAPITULASI OPERASIONAL';
        $periodText = Carbon::parse($startDate)->translatedFormat('d F Y').' s/d '.Carbon::parse($endDate)->translatedFormat('d F Y');
        $printedAt = Carbon::now()->translatedFormat('l, d F Y - H:i:s').' WIB';

        ob_start();
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Laporan</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        echo '<style>';
        echo 'body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }';
        echo 'table { border-collapse: collapse; width: 100%; }';
        echo '.title { font-size: 14pt; font-weight: bold; color: #14532d; text-align: center; }';
        echo '.subtitle { font-size: 10pt; color: #334155; text-align: center; font-weight: bold; }';
        echo '.meta { font-size: 9pt; color: #64748b; text-align: center; font-style: italic; }';
        echo 'th { background-color: #14532d; color: #ffffff; font-weight: bold; font-size: 10pt; border: 1px solid #0f391e; padding: 8px 10px; text-align: center; vertical-align: middle; }';
        echo 'td { border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 10pt; vertical-align: middle; }';
        echo '.text-center { text-align: center; }';
        echo '.text-right { text-align: right; }';
        echo '.text-left { text-align: left; }';
        echo '.font-bold { font-weight: bold; }';
        echo '.text-mono { font-family: "Courier New", monospace; }';
        echo '.bg-even { background-color: #f8fafc; }';
        echo '.bg-odd { background-color: #ffffff; }';
        echo '.footer-row { background-color: #e2e8f0; font-weight: bold; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<table>';

        if ($reportType === 'schedule') {
            echo '<tr><td colspan="11" class="title" style="border:none; height:30px;">TAMAN SAFARI INDONESIA BOGOR</td></tr>';
            echo "<tr><td colspan=\"11\" class=\"subtitle\" style=\"border:none;\">{$reportTitle}</td></tr>";
            echo "<tr><td colspan=\"11\" class=\"meta\" style=\"border:none;\">Periode: {$periodText} • Dicetak: {$printedAt}</td></tr>";
            echo '<tr><td colspan="11" style="border:none; height:12px;"></td></tr>';
            echo '<tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Shift</th>
                    <th>Jam Tugas</th>
                    <th>Posko Shelter</th>
                    <th>Zona Wilayah</th>
                    <th>Nama Personel</th>
                    <th>NRP</th>
                    <th>Status</th>
                    <th>Catatan Khusus</th>
                  </tr>';

            foreach ($data as $idx => $row) {
                $bgClass = ($idx % 2 === 0) ? 'bg-even' : 'bg-odd';
                $dateFormatted = $row->date ? $row->date->format('d/m/Y') : '-';
                $timeFormatted = substr($row->start_time, 0, 5).' - '.substr($row->end_time, 0, 5).' WIB';
                $shelterName = htmlspecialchars($row->shelter?->name ?? '-');
                $zone = htmlspecialchars($row->shelter?->zone ?? '-');
                $officerName = htmlspecialchars($row->officer?->name ?? '-');
                $nrp = htmlspecialchars($row->officer?->nrp ?? '-');
                $status = htmlspecialchars($row->status);
                $notes = htmlspecialchars($row->notes ?? '-');

                echo "<tr class=\"{$bgClass}\">
                        <td class=\"text-center\">".($idx + 1)."</td>
                        <td class=\"text-center\" style=\"mso-number-format:'dd\/mm\/yyyy';\">{$dateFormatted}</td>
                        <td class=\"text-center\">{$row->day}</td>
                        <td class=\"text-center font-bold\">{$row->shift}</td>
                        <td class=\"text-center text-mono\" style=\"mso-number-format:'\@';\">{$timeFormatted}</td>
                        <td class=\"text-left font-bold\">{$shelterName}</td>
                        <td class=\"text-center\">{$zone}</td>
                        <td class=\"text-left\">{$officerName}</td>
                        <td class=\"text-center text-mono\" style=\"mso-number-format:'\@';\">{$nrp}</td>
                        <td class=\"text-center font-bold\">{$status}</td>
                        <td class=\"text-left\">{$notes}</td>
                      </tr>";
            }

            $totalCount = count($data);
            echo "<tr class=\"footer-row\">
                    <td colspan=\"4\" class=\"text-right font-bold\">Total Rekapitulasi:</td>
                    <td colspan=\"7\" class=\"font-bold\">{$totalCount} Jadwal Penugasan Terdata</td>
                  </tr>";
        } elseif ($reportType === 'officer') {
            echo '<tr><td colspan="9" class="title" style="border:none; height:30px;">TAMAN SAFARI INDONESIA BOGOR</td></tr>';
            echo "<tr><td colspan=\"9\" class=\"subtitle\" style=\"border:none;\">{$reportTitle}</td></tr>";
            echo "<tr><td colspan=\"9\" class=\"meta\" style=\"border:none;\">Periode: {$periodText} • Dicetak: {$printedAt}</td></tr>";
            echo '<tr><td colspan="9" style="border:none; height:12px;"></td></tr>';
            echo '<tr>
                    <th>No</th>
                    <th>NRP / NIP</th>
                    <th>Nama Lengkap Personel</th>
                    <th>Jabatan</th>
                    <th>Nomor Telepon</th>
                    <th>Email Resmi</th>
                    <th>Posko Penempatan</th>
                    <th>Status</th>
                    <th>Total Sesi Jaga</th>
                  </tr>';

            foreach ($data as $idx => $row) {
                $bgClass = ($idx % 2 === 0) ? 'bg-even' : 'bg-odd';
                $nrp = htmlspecialchars($row->nrp);
                $name = htmlspecialchars($row->name);
                $position = htmlspecialchars($row->position);
                $phone = htmlspecialchars($row->phone ?? '-');
                $email = htmlspecialchars($row->email ?? '-');
                $shelter = htmlspecialchars($row->shelter?->name ?? 'Posko Induk');
                $status = htmlspecialchars($row->status);
                $sessions = $row->schedules_count ?? 0;

                echo "<tr class=\"{$bgClass}\">
                        <td class=\"text-center\">".($idx + 1)."</td>
                        <td class=\"text-center text-mono font-bold\" style=\"mso-number-format:'\@';\">{$nrp}</td>
                        <td class=\"text-left font-bold\">{$name}</td>
                        <td class=\"text-left\">{$position}</td>
                        <td class=\"text-center text-mono\" style=\"mso-number-format:'\@';\">{$phone}</td>
                        <td class=\"text-left\">{$email}</td>
                        <td class=\"text-left\">{$shelter}</td>
                        <td class=\"text-center font-bold\">{$status}</td>
                        <td class=\"text-center font-bold\">{$sessions} Sesi</td>
                      </tr>";
            }

            $totalCount = count($data);
            echo "<tr class=\"footer-row\">
                    <td colspan=\"4\" class=\"text-right font-bold\">Total Personel:</td>
                    <td colspan=\"5\" class=\"font-bold\">{$totalCount} Petugas Terdaftar</td>
                  </tr>";
        } elseif ($reportType === 'shelter') {
            echo '<tr><td colspan="11" class="title" style="border:none; height:30px;">TAMAN SAFARI INDONESIA BOGOR</td></tr>';
            echo "<tr><td colspan=\"11\" class=\"subtitle\" style=\"border:none;\">{$reportTitle}</td></tr>";
            echo "<tr><td colspan=\"11\" class=\"meta\" style=\"border:none;\">Periode: {$periodText} • Dicetak: {$printedAt}</td></tr>";
            echo '<tr><td colspan="11" style="border:none; height:12px;"></td></tr>';
            echo '<tr>
                    <th>No</th>
                    <th>Kode Posko</th>
                    <th>Nama Posko Shelter</th>
                    <th>Zona Wilayah</th>
                    <th>Koordinator Lapangan</th>
                    <th>Kontak Darurat</th>
                    <th>Kapasitas</th>
                    <th>Terisi</th>
                    <th>Tingkat Risiko</th>
                    <th>Kuota Petugas</th>
                    <th>Status Kesiapan</th>
                  </tr>';

            foreach ($data as $idx => $row) {
                $bgClass = ($idx % 2 === 0) ? 'bg-even' : 'bg-odd';
                $code = htmlspecialchars($row->code);
                $name = htmlspecialchars($row->name);
                $zone = htmlspecialchars($row->zone);
                $coordName = htmlspecialchars($row->coordinator_name);
                $coordPhone = htmlspecialchars($row->coordinator_phone ?? '-');
                $risk = ucfirst(htmlspecialchars($row->risk_level));
                $status = ucfirst(str_replace('_', ' ', htmlspecialchars($row->status)));

                echo "<tr class=\"{$bgClass}\">
                        <td class=\"text-center\">".($idx + 1)."</td>
                        <td class=\"text-center text-mono font-bold\" style=\"mso-number-format:'\@';\">{$code}</td>
                        <td class=\"text-left font-bold\">{$name}</td>
                        <td class=\"text-center\">{$zone}</td>
                        <td class=\"text-left\">{$coordName}</td>
                        <td class=\"text-center text-mono\" style=\"mso-number-format:'\@';\">{$coordPhone}</td>
                        <td class=\"text-right\">{$row->capacity} Jiwa</td>
                        <td class=\"text-right font-bold\">{$row->current_occupancy} Jiwa</td>
                        <td class=\"text-center\">{$risk}</td>
                        <td class=\"text-center\">{$row->guard_quota} Personel</td>
                        <td class=\"text-center font-bold\">{$status}</td>
                      </tr>";
            }

            $totalCount = count($data);
            echo "<tr class=\"footer-row\">
                    <td colspan=\"4\" class=\"text-right font-bold\">Total Posko:</td>
                    <td colspan=\"7\" class=\"font-bold\">{$totalCount} Unit Shelter Aktif</td>
                  </tr>";
        }

        echo '</table>';
        echo '</body>';
        echo '</html>';

        $content = ob_get_clean();

        ActivityLog::log(
            'EXPORT',
            'Laporan',
            "Mengekspor spreadsheet Excel untuk Laporan {$reportType} periode {$startDate} s/d {$endDate}."
        );

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate, proxy-revalidate',
        ]);
    }

    private function fetchReportData(string $reportType, string $startDate, string $endDate, string $shelterId, string $shift)
    {
        if ($reportType === 'schedule') {
            $query = Schedule::with(['shelter', 'officer'])->whereBetween('date', [$startDate, $endDate]);
            if ($shelterId !== 'all') {
                $query->where('shelter_id', $shelterId);
            }
            if ($shift !== 'all') {
                $query->where('shift', $shift);
            }

            return $query->orderBy('date', 'asc')->orderBy('start_time', 'asc')->get();
        }

        if ($reportType === 'officer') {
            $query = Officer::with(['shelter'])->withCount(['schedules' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }]);
            if ($shelterId !== 'all') {
                $query->where('shelter_id', $shelterId);
            }

            return $query->orderBy('name', 'asc')->get();
        }

        $query = Shelter::withCount(['officers', 'schedules' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        }]);
        if ($shelterId !== 'all') {
            $query->where('id', $shelterId);
        }

        return $query->orderBy('code', 'asc')->get();
    }
}
