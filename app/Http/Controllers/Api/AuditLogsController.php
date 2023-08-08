<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AuditLogs;
use Illuminate\Http\Request;

class AuditLogsController extends Controller
{
    /**
     * Retrieve all audit logs.
     *
     * This function retrieves all audit logs from the "AuditLogs" table and returns them as a JSON response.
     * The audit logs are ordered in descending order based on the creation date ('created_at').
     *
     * @return \Illuminate\Http\Response The JSON response containing all audit logs.
     */
    public function index()
    {
        // Retrieve all audit logs from the "AuditLogs" table and order them in descending order based on creation date.
        $AuditLogs = AuditLogs::select(
            'id',
            'audit_Name',
            'audit_Page',
            'audit_itemNo',
            'audit_action',
            'created_at'
        )
            ->orderBy('created_at', 'DESC')
            ->get();

        // Return a JSON response containing all audit logs.
        return response(['status' => 200, 'Logs' => $AuditLogs], 200);
    }

    /**
     * Store a new audit log entry.
     *
     * This function creates a new "AuditLogs" record in the database with the provided audit log information.
     * The audit log entry includes details such as audit name, audit page, audit item number, and audit action.
     *
     * @param \Illuminate\Http\Request $request The request containing the audit log information.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "AuditLogs" model.
        $audit_log = new AuditLogs();

        // Set the audit log information from the request data.
        $audit_log->audit_Name = $request->input('Audit_Name');
        $audit_log->audit_Page = $request->input('Audit_Page');
        $audit_log->audit_itemNo = $request->input('Audit_ItemNo');
        $audit_log->audit_action = $request->input('Audit_Action');

        // Save the new audit log entry to the database.
        $audit_log->save();

        // Return a JSON response indicating the successful addition.
        return response(['status' => 200, 'Logs' => 'Action Logged'], 200);
    }
}
