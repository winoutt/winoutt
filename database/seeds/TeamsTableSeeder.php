<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    private function getPhoto ($slug) {
        $base = 'https://oceanpace-prod.s3.us-east-2.amazonaws.com/assets/teams/';
        return $base.$slug.'.png';
    }

    public function teams () {
        return collect([
            [
                'name' => 'Personal Development',
                'slug' => 'personal-development',
                'photo' => $this->getPhoto('personal-development'),
                'goal' => 'Accepting responsibility for our lives; developing an attitude of constant life improvement. Unlocking our true potential.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'photo' => $this->getPhoto('books'),
                'goal' => 'Acquiring the right knowledge for new ways of thinking and insights; reading books to solve our problems.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Health & Fitness',
                'slug' => 'health-fitness',
                'photo' => $this->getPhoto('health-fitness'),
                'goal' => 'Taking steps forward to get in shape and feel great. Staying healthy enjoy our success in life and business.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Pains, Pleasures & Ideas',
                'slug' => 'pains-pleasures-ideas',
                'photo' => $this->getPhoto('pains-pleasures-ideas'),
                'goal' => 'Analyzing our daily frustrations, uncovering problems in need of solutions, and determining better ways of doing something. Solve a pain, provide a pleasure, or both.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Entrepreneurship',
                'slug' => 'entrepreneurship',
                'photo' => $this->getPhoto('entrepreneurship'),
                'goal' => 'Exposing ourselves to different bootstrapping strategies, side hustle concepts, owning and operating our businesses, accelerating wealth, and achieving liberty for life.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Innovation',
                'slug' => 'innovation',
                'photo' => $this->getPhoto('innovation'),
                'goal' => 'Identifying opportunities for innovation; create value for our customers by introducing new or improved products, services or processes.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Sales & Marketing',
                'slug' => 'sales-marketing',
                'photo' => $this->getPhoto('sales-marketing'),
                'goal' => 'Building a strong brand reputation. Generating leads and driving traffic to our businesses. Increasing customer satisfaction and jump-starting sales.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Leadership',
                'slug' => 'leadership',
                'photo' => $this->getPhoto('leadership'),
                'goal' => 'Taking ownership of our mistakes and failures; becoming leaders who would leverage a natural group of people to get unnatural results.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Business Growth',
                'slug' => 'business-growth',
                'photo' => $this->getPhoto('business-growth'),
                'goal' => 'Scaling up our businesses and seeking to reach external markets. Expanding the economic pie by bringing in new wealth in the form of investments, jobs, and careers.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Programming',
                'slug' => 'programming',
                'photo' => $this->getPhoto('programming'),
                'goal' => 'Encouraging a love for coding now and for generations to come; developing coding skills that are crucial for the future of businesses.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Art',
                'slug' => 'art',
                'photo' => $this->getPhoto('art'),
                'goal' => 'Exploring the world of art and design, mastering sophisticated skills, and breaking the rules to convey our ideas in a way that is not only effective but also visually beautiful.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Real Estate',
                'slug' => 'real-estate',
                'photo' => $this->getPhoto('real-estate'),
                'goal' => 'Gaining an understanding of various real estate strategies from an entrepreneurial standpoint in addition to learning the proper implementation, assessment, and adjustment.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Finance & Investing',
                'slug' => 'finance-investing',
                'photo' => $this->getPhoto('finance-investing'),
                'goal' => 'Examining the types of available investment options, discovering long-term and short-term investments, effectively planning and managing our money, and reducing unnecessary spending.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Startups',
                'slug' => 'startups',
                'photo' => $this->getPhoto('startups'),
                'goal' => 'Launching startup companies and revealing them to the world. Sharing our startups to raise funding or simply let everyone know we have great products/services that others should begin using today!',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
            [
                'name' => 'Legal',
                'slug' => 'legal',
                'photo' => $this->getPhoto('legal'),
                'goal' => 'Discussing legal matters that should be considered when starting a business; learning about business structures, protecting our business names, partnership agreements, and much more.',
                'placeholder' => 'Share your thoughts and experiences.'
            ],
        ]);
    }

    public function run()
    {
        $this->teams()
            ->each(function($team) {
                Team::create($team);
            });
    }
}
