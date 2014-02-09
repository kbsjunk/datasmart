<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('users')->truncate();

		$users = array(
			array(
				'username' => 'firstuser',
				'email' => 'first@localhost',
				'password' => Hash::make('first')
				),
			array(
				'username' => 'seconduser',
				'email' => 'second@localhost',
				'password' => Hash::make('second')
				)
			);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
