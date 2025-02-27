<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $group = $request->group_id;

        // Barcha guruhlarni olish
        $groups = Group::all();

        // Talabalarni guruh bo‘yicha filtrlash
        $students = User::with(['groups', 'address'])
            ->where('is_student', 1)
            ->when($group, function ($query) use ($group) {
                $query->whereHas('groups', function ($query) use ($group) {
                    $query->where('groups.id', $group);
                });
            })
            ->paginate(15)
            ->appends(request()->query()); // 🔹 So‘rov parametrlarini saqlaydi

        return view('student.index', compact('students', 'group', 'groups'));
    }

    public function create()
    {
        $student = new User();
        return view('student.create', compact('student'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);
        $phone = preg_replace('/\D/', '', $request->phone); // Faqat raqamlarni olish

        if (strlen($phone) == 9) {
            $phone = '998' . $phone;
        }

        if (!str_starts_with($phone, '998')) {
            $phone = '998' . $phone;
        }

        $phone = '+'.$phone;
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'phone' => $phone,
                'is_student' => 1,
                'password' => $request->password
            ]);
            $user->assignRole('User');
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error($exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
        return redirect()->back()->with('success', 'Talaba muvofaqiyatli saqlandi');
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $student = User::find($id);
        return view('student.create', compact('student'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'password' => 'nullable',
        ]);
        $student = User::find($id);
        $phone = preg_replace('/\D/', '', $request->phone); // Faqat raqamlarni olish

        if (strlen($phone) == 9) {
            $phone = '998' . $phone;
        }

        if (!str_starts_with($phone, '998')) {
            $phone = '998' . $phone;
        }

        $phone = '+'.$phone;
        try {
            DB::beginTransaction();
            $student->update([
                'name' => $request->name,
                'phone' => $phone,
            ]);
            if ($request->password) {
                $student->update([
                    'password' => $request->password
                ]);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error($exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
        return redirect()->route('students.index')->with('success', 'Talaba muvofaqiyatli yangilandi');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Student muvofaqiyatli o\'chirildi');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'password' => 'nullable',
        ]);
        $phone = preg_replace('/\D/', '', $request->phone); // Faqat raqamlarni olish

        if (strlen($phone) == 9) {
            $phone = '998' . $phone;
        }

        if (!str_starts_with($phone, '998')) {
            $phone = '998' . $phone;
        }

        $phone = '+'.$phone;

        $user = Auth::user();
        try {
            DB::beginTransaction();
            $user->update([
                'name' => $request->name,
                'phone' => $phone,
            ]);
            if ($request->password) {
                $user->update([
                    'password' => $request->password
                ]);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect()->back()->with('success', 'Foydalanuvchi malumotlari muvofaqiyatli yangilandi');
    }
}
