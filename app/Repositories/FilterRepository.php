<?php

namespace App\Repositories;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
class FilterRepository extends Controller
{
    public function bugungi(Request $request)
    {
        $requests = DB::table('requests')
            ->leftJoin('kafedras', 'requests.kafedra_id', '=', 'kafedras.id')
            ->whereDate('requests.created_at', '=', today())
            ->select('requests.*', 'kafedras.name as name')
            ->latest('requests.created_at') // specify the table for sorting
            ->get();

        return view('requests.index', ['requests' => $requests]);
    }

    public function bajarilmagani(Request $request)
    {
        $requests = DB::table('requests')
            ->leftJoin('kafedras', 'requests.kafedra_id', '=', 'kafedras.id')
            ->where('requests.status', '=', 'new')
            ->select('requests.*', 'kafedras.name as name')
            ->latest('requests.created_at')
            ->get();

        return view('requests.index', ['requests' => $requests]);
    }

    public function changeStatus(Request $request)
    {
        try {
            $rq = DB::table('requests')->where('id', $request->id)->first();
            if ($rq->status == 'done' && $request->status != 'done'){
                return response()->json([
                    'success' => false,
                    'message' => 'Bu so\'rovnoma bajarilgan o\'zgartirib bo\'lmaydi!'
                ]);
            }
            DB::table('requests')->where('id', $request->id)->update(['status' => $request->status]);
            DB::table('audits')->insert([
                'user_id' => auth()->id(),
                'event' => $request->status,
                'auditable_type' => 'App\Models\Request',
                'auditable_id' => $request->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Request status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function confirm(Request $request)
    {
        DB::table('requests')->where('id', $request->id)->update(['confirm' => true]);
        return response()->json([
            'success' => true,
            'message' => 'Request confirmed successfully'
        ]);
    }

    public function word($id)
    {
        $requests = DB::table('requests')
            ->leftJoin('kafedras', 'kafedras.id', '=', 'requests.kafedra_id')
            ->join('users', 'users.id', '=', 'requests.from')
            ->select('requests.*', 'kafedras.name as name', 'users.name as user')
            ->where('requests.id', '=', $id)
            ->first();

        // Load the template
        $templateProcessor = new TemplateProcessor(public_path('sorovnoma.docx'));

        $templateProcessor->setValue('name', $this->changeText($requests->name));
        $templateProcessor->setValue('user', $requests->user);
        $templateProcessor->setValue('building', $requests->building);
        $templateProcessor->setValue('floor', $requests->floor);
        $templateProcessor->setValue('room', $requests->room);
        $templateProcessor->setValue('description', $requests->description);

        // Format the date before setting the value
        $templateProcessor->setValue('date', Carbon::parse($requests->created_at)->format('Y-m-d'));

        // Generate file name
        $fileName = 'sorovnoma' . time() . '.docx';

        // Stream the document to the browser for download
        $response = new StreamedResponse(function () use ($templateProcessor) {
            $templateProcessor->saveAs('php://output');
        });

        // Set headers for the response
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'public');

        return $response;
    }
    private function changeText(string $text)
    {
        if (strpos($text, '(') !== false) {
            $result = strstr($text, '(', true);
        } else {
            $result = $text; // Matnni o'zi qaytaradi
        }
        return $result;
    }
}
