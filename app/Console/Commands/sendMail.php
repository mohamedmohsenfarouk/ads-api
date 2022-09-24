<?php

namespace App\Console\Commands;

use App\Mail\Gmail;
use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->addDay(1)->format('Y-m-d');

        $data = Ad::with('advertiser')->with('tags')->with('category')
            ->where('start_date', $date)->get();

        $all_data = [];
        foreach ($data as $val) {
            $all_tags = [];
            $cat_name = $val->getCategoryName($val->category);
            $name = $val->getAdvertiserName($val->advertiser);
            $email = $val->getAdvertiserEmail($val->advertiser);
            foreach ($val->tags as $tag) {
                array_push($all_tags, $tag->name);
            }

            $mail_data = [
                'count' => count($data),
                'title' => 'Mail from Ads API',
                'ads_title' => $val->title,
                'advertiser' => $name,

            ];
            array_push($all_data, $mail_data);
            print("Email sent successfully." . $val->id);
        }
        Mail::to($email)->send(new Gmail($all_data));
        return 0;
    }
}
