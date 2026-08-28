<?php

namespace Tests\Feature;

use App\Entity\User;
use App\Exam\RoomExam;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmployerRoomExamTest extends TestCase
{
    use DatabaseTransactions;

    public function test_employer_can_open_room_list_and_edit_form(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        $room = RoomExam::create([
            'code_room' => 'PT-ROUTE-TEST',
            'name_room' => 'Phòng thi kiểm thử resource route',
            'password_room' => 'secret123',
            'day_room' => '2026-08-28',
            'time_star_room' => '2026-08-28 09:00:00',
            'time_end_room' => '2026-08-28 10:00:00',
            'user_create_room' => $employer->id,
            'id_exam' => 0,
            'type_exam' => 0,
        ]);

        $listResponse = $this->actingAs($employer)->get(route('room.index'));

        $listResponse->assertOk();
        $listResponse->assertSee($room->name_room);
        $listResponse->assertSee(route('room.edit', ['room' => $room->id_room]), false);
        $listResponse->assertSee(route('room.destroy', ['room' => $room->id_room]), false);

        $editResponse = $this->actingAs($employer)->get(route('room.edit', [
            'room' => $room->id_room,
        ]));

        $editResponse->assertOk();
        $editResponse->assertSee(route('room.update', ['room' => $room->id_room]), false);
    }

    public function test_employer_can_create_room_and_return_to_room_list(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();

        $response = $this->actingAs($employer)->post(route('room.store'), [
            'name_room' => 'Phòng thi vừa tạo',
            'des_room' => 'Kiểm thử luồng tạo phòng thi',
            'password_room' => 'secret123',
            'day_room' => '2026-08-29',
            'time_star_room' => '09:00',
            'time_end_room' => '10:00',
            'type_exam' => 0,
        ]);

        $room = RoomExam::where('name_room', 'Phòng thi vừa tạo')
            ->where('user_create_room', $employer->id)
            ->firstOrFail();

        $response->assertRedirect(route('getRomExam', ['id_room' => $room->id_room]));

        $this->actingAs($employer)
            ->get(route('room.index'))
            ->assertOk()
            ->assertSee($room->name_room);
    }
}
