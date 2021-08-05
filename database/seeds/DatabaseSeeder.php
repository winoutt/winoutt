<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static function probability($ratio = 10)
    {
        $faker = Factory::create();
        return !$faker->boolean($ratio);
    }

    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(UnfollowsTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(PostAlbumPhotosTableSeeder::class);
        $this->call(PollsTableSeeder::class);
        $this->call(PollChoicesTableSeeder::class);
        $this->call(PollVotesTableSeeder::class);
        $this->call(PostContentsTableSeeder::class);
        $this->call(ConnectionsTableSeeder::class);
        $this->call(StarsTableSeeder::class);
        $this->call(HashtagsTableSeeder::class);
        $this->call(PostHashtagTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(PostMentionTableSeeder::class);
        $this->call(CommentMentionTableSeeder::class);
        $this->call(CommentHashtagTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(LastMessagesTableSeeder::class);
        $this->call(NotesTableSeeder::class);
        $this->call(FavouritesTableSeeder::class);
        $this->call(ReportingsTableSeeder::class);
        $this->call(WebsitesTableSeeder::class);
        $this->call(ChatArchivesTableSeeder::class);
    }
}
