<?php

namespace Tests\Unit\Jobs;

use App\Account;
use App\User;
use App\Changelog;
use Tests\TestCase;
use App\Jobs\AddChangelogEntry;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddChangelogEntryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_adds_a_changelog_entry()
    {
        $account = factory(Account::class)->create([]);
        $user = factory(User::class)->create(['account_id' => $account->id]);
        $changelog = factory(Changelog::class)->create([]);

        dispatch(new AddChangelogEntry($account, $changelog->id));

        $this->assertDatabaseHas('changelog_user', [
            'user_id' => $user->id,
            'changelog_id' => $changelog->id,
        ]);
    }
}
