<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        return view('ManagerAdmin.Accounts.index');
    }
    public function accountsAdminList()
    {
        return view('ManagerAdmin.Accounts.Admin.adminList');
    }

    public function accountsSuperstarList()
    {
        return view('ManagerAdmin.Accounts.Superstar.superstarList');
    }

    public function accountsAuditionAdminList()
    {
        return view('ManagerAdmin.Accounts.AuditionAdmin.auditionAdminList');
    }
    public function adminIncome()
    {
        return view('ManagerAdmin.Accounts.Admin.adminDashboard');
    }
    public function superstarIncome()
    {
        return view('ManagerAdmin.Accounts.Superstar.superstarDashboard');
    }
    public function auditionIncome()
    {
        return view('ManagerAdmin.Accounts.AuditionAdmin.auditionAdminDashboard');
    }


    // Simple Post


    public function simplePostTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.SimplePost.simplePostTotalIncome');
    }
    public function simplePostDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.SimplePost.simplePostDailyIncome');
    }
    public function simplePostWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.SimplePost.simplePostWeeklyIncome');
    }
    public function simplePostMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.SimplePost.simplePostMonthlyIncome');
    }
    public function simplePostYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.SimplePost.simplePostYearlyIncome');
    }

    // live chats
    public function liveChatTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LiveChat.liveChatTotalIncome');
    }
    public function liveChatDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LiveChat.liveChatDailyIncome');
    }
    public function liveChatWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LiveChat.liveChatWeeklyIncome');
    }
    public function liveChatMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LiveChat.liveChatMonthlyIncome');
    }
    public function liveChatYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LiveChat.liveChatYearlyIncome');
    }
    // meetup events
    public function meetupTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Meetup.meetupTotalIncome');
    }
    public function meetupDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Meetup.meetupDailyIncome');
    }
    public function meetupWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Meetup.meetupWeeklyIncome');
    }
    public function meetupMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Meetup.meetupMonthlyIncome');
    }
    public function meetupYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Meetup.meetupYearlyIncome');
    }

    // Greetings

    public function greetingTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Greeting.greetingTotalIncome');
    }
    public function greetingDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Greeting.greetingDailyIncome');
    }
    public function greetingWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Greeting.greetingWeeklyIncome');
    }
    public function greetingMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Greeting.greetingMonthlyIncome');
    }
    public function greetingYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Greeting.greetingYearlyIncome');
    }
    // learningSession
    public function learningSessionTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LearningSession.learningSessionTotalIncome');
    }
    public function learningSessionDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LearningSession.learningSessionDailyIncome');
    }
    public function learningSessionWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LearningSession.learningSessionWeeklyIncome');
    }
    public function learningSessionMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LearningSession.learningSessionMonthlyIncome');
    }
    public function learningSessionYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.LearningSession.learningSessionYearlyIncome');
    }
    // Audition
    public function auditionTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Audition.auditionTotalIncome');
    }
    public function auditionDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Audition.auditionDailyIncome');
    }
    public function auditionWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Audition.auditionWeeklyIncome');
    }
    public function auditionMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Audition.auditionMonthlyIncome');
    }
    public function auditionYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.Audition.auditionYearlyIncome');
    }
    // Qna
    public function qnaTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.QnA.qnaTotalIncome');
    }
    public function qnaDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.QnA.qnaDailyIncome');
    }
    public function qnaWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.QnA.qnaWeeklyIncome');
    }
    public function qnaMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.QnA.qnaMonthlyIncome');
    }
    public function qnaYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.QnA.qnaYearlyIncome');
    }
    // marketplace
    public function marketplaceTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceTotalIncome');
    }
    public function marketplaceDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceDailyIncome');
    }
    public function marketplaceWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceWeeklyIncome');
    }
    public function marketplaceMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceMonthlyIncome');
    }
    public function marketplaceYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Marketplace.marketplaceYearlyIncome');
    }
    // souvenir
    public function souvenirTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirTotalIncome');
    }
    public function souvenirDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirDailyIncome');
    }
    public function souvenirWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirWeeklyIncome');
    }
    public function souvenirMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirMonthlyIncome');
    }
    public function souvenirYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Souvenir.souvenirYearlyIncome');
    }
    // auction
    public function auctionTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Auction.auctionTotalIncome');
    }
    public function auctionDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Auction.auctionDailyIncome');
    }
    public function auctionWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Auction.auctionWeeklyIncome');
    }
    public function auctionMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Auction.auctionMonthlyIncome');
    }
    public function auctionYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.StarShowcase.Auction.auctionYearlyIncome');
    }

    // fan gorup
    public function fanGroupTotalIncome()
    {

        return view('ManagerAdmin.Accounts.Events.FanGroup.fanGroupTotalIncome');
    }
    public function fanGroupDailyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.FanGroup.fanGroupDailyIncome');
    }
    public function fanGroupWeeklyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.FanGroup.fanGroupWeeklyIncome');
    }
    public function fanGroupMonthlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.FanGroup.fanGroupMonthlyIncome');
    }
    public function fanGroupYearlyIncome()
    {

        return view('ManagerAdmin.Accounts.Events.FanGroup.fanGroupYearlyIncome');
    }
}
