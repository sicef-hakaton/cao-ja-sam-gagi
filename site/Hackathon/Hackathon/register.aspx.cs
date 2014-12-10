using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Web;
using System.Web.Helpers;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Hackathon
{
    public partial class Register : System.Web.UI.Page
    {
        private const string ServerHttpGetRequestUrl = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/create_profile.php?";
        private const string SuccessRegisterMessage = "Success";

        protected void Page_Load(object sender, EventArgs e)
        {
            
        }

        protected void RegisterUser(object sender, EventArgs e)
        {
            WebClient webclient = new WebClient();

            // create http get request
            StringBuilder httpGetRequestUrl = new StringBuilder(Register.ServerHttpGetRequestUrl);
            httpGetRequestUrl.Append("email=" + email.Text);
            httpGetRequestUrl.Append("&password=" + password.Text);
            httpGetRequestUrl.Append("&password2=" + confirmPassword.Text);
            httpGetRequestUrl.Append("&first_name=" + firstName.Text);
            httpGetRequestUrl.Append("&last_name=" + lastName.Text);

            string result = webclient.DownloadString(httpGetRequestUrl.ToString());
            dynamic json = Classes.Functions.getJson(result);

            if (((string)json.message).Equals(Register.SuccessRegisterMessage))
            {
                Response.Redirect("Home.aspx", true);
            }
            else
            {
                failureMessage.Text = (string)json.message;
            }
        }
    }
}