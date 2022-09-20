<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('SuperAdmin.Accounts.index', compact('categories'));
    }

    public function accountSuperStarName($subCat_id, $cat_id)
    {
        // $sub_cat= $subCat_id;
        // $cate_id = $cat_id;

        $superstar = User::where('sub_category_id', $subCat_id)->where('category_id', $cat_id)->where('user_type', "star")->get();
        return response()->json($superstar);
    }

    public function allSubCategory($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json($subCategories);
    }


    public function totalEvents()
    {

        return view('SuperAdmin.Accounts.Events.totalEvents');
    }
    public function dailyEvents()
    {

        return view('SuperAdmin.Accounts.Events.dailyEvents');
    }
    public function weeklyEvents()
    {

        return view('SuperAdmin.Accounts.Events.weeklyEvents');
    }
    public function monthlyEvents()
    {

        return view('SuperAdmin.Accounts.Events.monthlyEvents');
    }
    public function yearlyEvents()
    {

        return view('SuperAdmin.Accounts.Events.yearlyEvents');
    }


    // Simple Post


    public function simplePostTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.SimplePost.simplePostTotalIncome');
    }
    public function simplePostDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.SimplePost.simplePostDailyIncome');
    }
    public function simplePostWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.SimplePost.simplePostWeeklyIncome');
    }
    public function simplePostMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.SimplePost.simplePostMonthlyIncome');
    }
    public function simplePostYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.SimplePost.simplePostYearlyIncome');
    }

    // live chats
    public function liveChatTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.LiveChat.liveChatTotalIncome');
    }
    public function liveChatDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LiveChat.liveChatDailyIncome');
    }
    public function liveChatWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LiveChat.liveChatWeeklyIncome');
    }
    public function liveChatMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LiveChat.liveChatMonthlyIncome');
    }
    public function liveChatYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LiveChat.liveChatYearlyIncome');
    }
    // meetup events
    public function meetupTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.Meetup.meetupTotalIncome');
    }
    public function meetupDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Meetup.meetupDailyIncome');
    }
    public function meetupWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Meetup.meetupWeeklyIncome');
    }
    public function meetupMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Meetup.meetupMonthlyIncome');
    }
    public function meetupYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Meetup.meetupYearlyIncome');
    }

    // Greetings

    public function greetingTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.Greeting.greetingTotalIncome');
    }
    public function greetingDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Greeting.greetingDailyIncome');
    }
    public function greetingWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Greeting.greetingWeeklyIncome');
    }
    public function greetingMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Greeting.greetingMonthlyIncome');
    }
    public function greetingYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Greeting.greetingYearlyIncome');
    }
    // learningSession
    public function learningSessionTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionTotalIncome');
    }
    public function learningSessionDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionDailyIncome');
    }
    public function learningSessionWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionWeeklyIncome');
    }
    public function learningSessionMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionMonthlyIncome');
    }
    public function learningSessionYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.LearningSession.learningSessionYearlyIncome');
    }
    // Audition
    public function auditionTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.Audition.auditionTotalIncome');
    }
    public function auditionDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Audition.auditionDailyIncome');
    }
    public function auditionWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Audition.auditionWeeklyIncome');
    }
    public function auditionMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Audition.auditionMonthlyIncome');
    }
    public function auditionYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.Audition.auditionYearlyIncome');
    }
    // Qna
    public function qnaTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.QnA.qnaTotalIncome');
    }
    public function qnaDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.QnA.qnaDailyIncome');
    }
    public function qnaWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.QnA.qnaWeeklyIncome');
    }
    public function qnaMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.QnA.qnaMonthlyIncome');
    }
    public function qnaYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.QnA.qnaYearlyIncome');
    }
    // marketplace
    public function marketplaceTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceTotalIncome');
    }
    public function marketplaceDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceDailyIncome');
    }
    public function marketplaceWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceWeeklyIncome');
    }
    public function marketplaceMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceMonthlyIncome');
    }
    public function marketplaceYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceYearlyIncome');
    }
    // souvenir
    public function souvenirTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirTotalIncome');
    }
    public function souvenirDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirDailyIncome');
    }
    public function souvenirWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirWeeklyIncome');
    }
    public function souvenirMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirMonthlyIncome');
    }
    public function souvenirYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirYearlyIncome');
    }
    // auction
    public function auctionTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionTotalIncome');
    }
    public function auctionDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionDailyIncome');
    }
    public function auctionWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionWeeklyIncome');
    }
    public function auctionMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionMonthlyIncome');
    }
    public function auctionYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.StarShowcase.Auction.auctionYearlyIncome');
    }

    // fan gorup
    public function fanGroupTotalIncome()
    {

        return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupTotalIncome');
    }
    public function fanGroupDailyIncome()
    {

        return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupDailyIncome');
    }
    public function fanGroupWeeklyIncome()
    {

        return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupWeeklyIncome');
    }
    public function fanGroupMonthlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupMonthlyIncome');
    }
    public function fanGroupYearlyIncome()
    {

        return view('SuperAdmin.Accounts.Events.FanGroup.fanGroupYearlyIncome');
    }
    public function managerAdminList()
    {

        return view('SuperAdmin.Accounts.ManagerAdmin.managerAdminList');
    }
    public function managerAdminIncome()
    {

        return view('SuperAdmin.Accounts.ManagerAdmin.managerAdminIncome');
    }
    public function adminList()
    {

        return view('SuperAdmin.Accounts.Admin.adminList');
    }
    public function adminIncome()
    {

        return view('SuperAdmin.Accounts.Admin.adminIncome');
    }
    public function superstarList()
    {

        return view('SuperAdmin.Accounts.Superstar.superstarList');
    }
    public function superstarIncome()
    {

        return view('SuperAdmin.Accounts.Superstar.superstarIncome');
    }
    public function auditionAdminList()
    {

        return view('SuperAdmin.Accounts.AuditionAdmin.auditionAdminList');
    }
    public function auditionAdminIncome()
    {

        return view('SuperAdmin.Accounts.AuditionAdmin.auditionAdminIncome');
    }
}
