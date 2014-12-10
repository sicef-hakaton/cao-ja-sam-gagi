using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.Helpers;
using System.Web.Security;
using System.Text;

namespace Hackathon
{
    public partial class Login : System.Web.UI.Page
    {
        private const string ServerHttpGetRequestUrl = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/check_loginpass.php?";
        private const string SuccessLoginMessage = "Success";

        protected void Page_Load(object sender, EventArgs e)
        {
            if (this.Page.User.Identity.IsAuthenticated)
            {
                Response.Redirect("/Home.aspx");
            }
        }

        protected void ValidateUser(object sender, EventArgs e)
        {
            WebClient webclient = new WebClient();

            // create http get request
            StringBuilder httpGetRequestUrl = new StringBuilder(Login.ServerHttpGetRequestUrl);
            httpGetRequestUrl.Append("email=" + email.Text);
            httpGetRequestUrl.Append("&password=" + password.Text);

            string result = webclient.DownloadString(httpGetRequestUrl.ToString());
            dynamic json = Classes.Functions.getJson(result);

            if (((string)json.message).Equals(Login.SuccessLoginMessage))
            {
                FormsAuthentication.RedirectFromLoginPage(json.id, true);
            }
            else
            {
                failureMessage.Text = (string)json.message;
            }
        }

        protected void RegisterPage(object sender, EventArgs e)
        {
            Response.Redirect("Register.aspx", true);
        }
    }
}