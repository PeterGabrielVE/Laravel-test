<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Exception;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::all();
            return view('welcome', compact('tasks'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al cargar las tareas.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            Task::create([
                'title' => htmlspecialchars($request->title)
            ]);

            return redirect()->back()->with('success', 'Tarea creada exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al crear la tarea: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'in:0,1',
            ]);

            if ($request->has('title')) {
                $task->title = htmlspecialchars($request->input('title'));
            }
            if ($request->has('status')) {
                $task->status = $request->input('status');
            }

            $task->save();

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(['error' => 'Hubo un error al actualizar la tarea. ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return redirect()->back()->with('success', 'Tarea eliminada exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al eliminar la tarea: ' . $e->getMessage());
        }
    }
}
