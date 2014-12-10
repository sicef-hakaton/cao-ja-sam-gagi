using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Hackathon
{
    public partial class Session : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            // string myId = HttpContext.Current.User.Identity.Name;
            string teacherId = Request.Params["teacherId"];
            string myId = Request.Params["myId"];
            string myNameString = Request.Params["myNameString"];

            phantomKey.Value = myId;
            phantomName.Value = myNameString;
            phantomTeacherKey.Value = teacherId;

            //if (teacherId == null) teacherId = "100";
            //if (myId == null) myId = "5";

            if (myId.Equals(teacherId))
            {
                Page.ClientScript.RegisterStartupScript(GetType(), "myKey", "wireEvents();", true);
            }
        }
    }
}