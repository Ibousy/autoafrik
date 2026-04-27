<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Repair;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $employees = Employee::query()
            ->when($request->role,   fn ($q, $r) => $q->where('role', $r))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->search, fn ($q, $s) =>
                $q->where('first_name', 'like', "%$s%")
                  ->orWhere('last_name',  'like', "%$s%")
                  ->orWhere('phone',      'like', "%$s%")
            )
            ->withCount([
                'repairs as repairs_total',
                'repairs as repairs_this_month' => fn ($q) =>
                    $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                'repairs as repairs_done' => fn ($q) => $q->where('status', 'done'),
            ])
            ->latest()
            ->paginate(20);

        // Compute performance score (% of done repairs)
        $employees->getCollection()->transform(function ($emp) {
            $emp->performance = $emp->repairs_total > 0
                ? round(($emp->repairs_done / $emp->repairs_total) * 100)
                : 0;
            return $emp;
        });

        return response()->json($employees);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create(array_merge($request->validated(), ['company_id' => auth()->user()->company_id]));

        return response()->json([
            'message'  => 'Employé ajouté.',
            'employee' => $employee,
        ], 201);
    }

    public function show(Employee $employee): JsonResponse
    {
        $employee->load(['repairs.vehicle', 'user']);
        $employee->append(['repairs_this_month']);
        return response()->json($employee);
    }

    public function update(StoreEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $employee->update($request->validated());

        return response()->json([
            'message'  => 'Employé mis à jour.',
            'employee' => $employee->fresh(),
        ]);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->update(['status' => 'inactive']);
        return response()->json(['message' => 'Employé désactivé.']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total'        => Employee::where('status', 'active')->count(),
            'mechanics'    => Employee::where('status', 'active')
                ->whereIn('role', ['chef_mecanicien', 'mecanicien_senior', 'mecanicien', 'electricien'])->count(),
            'admin'        => Employee::where('status', 'active')
                ->whereIn('role', ['receptionniste', 'gerant', 'comptable', 'magasinier'])->count(),
            'total_payroll'=> Employee::where('status', 'active')->sum('salary'),
        ]);
    }
}
