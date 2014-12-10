using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;

namespace Hackathon.Classes
{
    public class Lecture
    {
        public int Id { get; set; }
        public DateTime BeginTime { get; set; }
        public int Duration { get; set; }
        public int TeacherId { get; set; }
        public string TeacherEmail { get; set; }
        public string TeacherFirstName { get; set; }
        public string TeacherLastName { get; set; }
        public int Cost { get; set; }
        public int MaxUsers { get; set; }
        public string Description { get; set; }
        public int NumberOfParticipants { get; set; }
        public int UserCredit { get; set; }
        public int Applied { get; set; }
        public int Active { get; set; }
        public string firstNameLastName { get; set; }

        public override string ToString()
        {
            return CreateLectureHTML();
        }

        private string CreateLectureHTML()
        {
            StringBuilder html = new StringBuilder();

            html.Append("<div class='leftDiv'>");
            html.Append("<div class='desciptionTitle'>Description</div>");
            html.Append("<div class='description'>" + Description + "</div>");
            html.Append("</div>");

            html.Append("<div class='rightDiv'>");
            html.Append("<div class='teacher'>Teacher: <a class='linkProfile' href='/Profile.aspx?id=" + TeacherId + "'>" + TeacherFirstName + " " + TeacherLastName + "</a></div>");
            html.Append("<div class='date'>Date: " + BeginTime.ToString("dd. MMM yyyy.") + "</div>");
            html.Append("<div class='time'>Time: " + BeginTime.ToString("HH:mm") + "</div>");
            html.Append("<div class='duration'>Duration: " + Duration + " min</div>");
            html.Append("<div class='users'>Number of users: " + NumberOfParticipants + "/" + MaxUsers + "</div>");

            if (NumberOfParticipants < MaxUsers && Applied == 0 && UserCredit >= Cost)
            {
                html.Append("<a href='/Home.aspx?applyForLecture=" + Id + "'><div class='button'>Listen $" + Cost + "</div></a>");
            }
            else if (Applied == 1)
            {
                html.Append("<div class='disabledButton'>Already applied</div>");
            }
            else if (UserCredit < Cost)
            {
                html.Append("<div class='disabledButton'>No enough money $" + Cost + "</div>");
            }
            else
            {
                html.Append("<div class='disabledButton'>No available slots</div>");
            }

            html.Append("</div>");

            html.Append("<div class='clear'></div>");

            return html.ToString();
        }
    }
}