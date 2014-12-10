using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Hackathon
{
    public partial class Profile : System.Web.UI.Page
    {
        private const string ServerHttpGetRequestUserData = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/get_profile_info.php?";
        private const string ServerHttpGetRequestVote = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/rate_user.php?";

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!this.Page.User.Identity.IsAuthenticated)
            {
                FormsAuthentication.RedirectToLoginPage();
            }
            else
            {
                if (Request.Params["voteup"] != null)
                {
                    VoteUp(Request.Params["id"]);
                    Response.Redirect("/Profile.aspx?id=" + Request.Params["id"]);
                }

                if (Request.Params["votedown"] != null)
                {
                    VoteDown(Request.Params["id"]);
                    Response.Redirect("/Profile.aspx?id=" + Request.Params["id"]);
                }

                string userId = Request.Params["id"];
                if ( userId == null ) userId = HttpContext.Current.User.Identity.Name;

                ShowUserData(userId);
            }
        }

        private void ShowUserData(string userId)
        {
            WebClient webClient = new WebClient();

            StringBuilder url = new StringBuilder(ServerHttpGetRequestUserData);
            url.Append("id=" + userId);

            string result = webClient.DownloadString(url.ToString());
            dynamic json = Classes.Functions.getJson(result);

            StringBuilder userHtml = new StringBuilder();
            userHtml.Append("<div>Email: " + json.email + "</div><br/>");
            userHtml.Append("<div>First name: " + json.first_name + "</div><br/>");
            userHtml.Append("<div>Last name: " + json.last_name + "</div><br/>");
            userHtml.Append("<div>Credit: " + json.credit + "</div><br/>");

            userHtml.Append("<div class='leftDiv'>");
            userHtml.Append("<a href='/Profile.aspx?id=" + userId + "&voteup=1'><div class='button' style='width: 100px; text-align: center; padding-top: 20px; padding-bottom: 20px;'>" + json.vote_up + "</div></a>");
            userHtml.Append("</div>");

            userHtml.Append("<div class='leftDiv'>");
            userHtml.Append("<a href='/Profile.aspx?id=" + userId + "&votedown=1'><div class='disabledButton' style='margin-left: 30px; width: 100px; text-align: center; padding-top: 20px; padding-bottom: 20px;'>" + json.vote_down + "</div></a>");
            userHtml.Append("</div>");

            userHtml.Append("<div class='clear'></div>");

            LiteralControl literalControl = new LiteralControl();
            literalControl.Text = userHtml.ToString();
            userData.Controls.Add(literalControl);
        }

        private void VoteDown(string id)
        {
            WebClient webClient = new WebClient();

            StringBuilder url = new StringBuilder(ServerHttpGetRequestVote);
            url.Append("teacher_id=" + id);
            url.Append("&value=-1");

            webClient.DownloadString(url.ToString());
        }

        private void VoteUp(string id)
        {
            WebClient webClient = new WebClient();

            StringBuilder url = new StringBuilder(ServerHttpGetRequestVote);
            url.Append("teacher_id=" + id);
            url.Append("&value=1");

            webClient.DownloadString(url.ToString());
        }
    }
}