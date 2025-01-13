<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function approve($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->status = 'approved';
        $approval->save();

        return response()->json(['message' => 'Aprovado!']);
    }

    public function reject($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->status = 'rejected';
        $approval->save();

        return response()->json(['message' => 'Rejeitado!']);
    }
}
