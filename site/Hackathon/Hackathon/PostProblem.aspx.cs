using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Web;
using System.Web.Helpers;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Hackathon
{
    public partial class PostProblem : System.Web.UI.Page
    {
        private const string ServerHttpGetRequestUrl = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/create_problem.php?";
        private const string SuccessLoginMessage = "Success";

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!this.Page.User.Identity.IsAuthenticated)
            {
                FormsAuthentication.RedirectToLoginPage();
            }
        }

        protected void SendPostProblem(object sender, EventArgs e)
        {
            WebClient webclient = new WebClient();

            StringBuilder httpGetRequestUrl = new StringBuilder(PostProblem.ServerHttpGetRequestUrl);
            httpGetRequestUrl.Append("begin_time=" + Classes.Functions.calculateTime(beginTime.Text, time.Text));
            httpGetRequestUrl.Append("&duration=" + Convert.ToInt32(duration.Text) * 60);
            httpGetRequestUrl.Append("&poster_id=" + HttpContext.Current.User.Identity.Name);
            httpGetRequestUrl.Append("&cost=" + cost.Text);
            httpGetRequestUrl.Append("&description=" + description.Text);

            string result = webclient.DownloadString(httpGetRequestUrl.ToString());
            dynamic json = Classes.Functions.getJson(result);

            if (((string)json.message).Equals(PostProblem.SuccessLoginMessage))
            {
                Response.Redirect("/Home.aspx");
            }
            else
            {
                failureMessage.Text = (string)json.message;
            }

        }
    }
}