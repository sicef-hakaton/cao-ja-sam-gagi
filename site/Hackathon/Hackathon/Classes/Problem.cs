using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;

namespace Hackathon.Classes
{
    public class Problem
    {
        public int Id { get; set; }
        public DateTime BeginTime { get; set; }
        public int Duration { get; set; }
        public int PosterId { get; set; }
        public string PosterEmail { get; set; }
        public string PosterFirstName { get; set; }
        public string PosterLastName { get; set; }
        public int Cost { get; set; }
        public int SolveId { get; set; }
        public string SolverEmail { get; set; }
        public string SolverFirstName { get; set; }
        public string SolverLastName { get; set; }
        public string Description { get; set; }
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
            html.Append("<div class='teacher'>Poster: <a class='linkProfile' href='/Profile.aspx?id=" + PosterId + "'>" + PosterFirstName + " " + PosterLastName + "</a></div>");
            html.Append("<div class='date'>Date: " + BeginTime.ToString("dd. MMM yyyy.") + "</div>");
            html.Append("<div class='time'>Time: " + BeginTime.ToString("HH:mm") + "</div>");
            html.Append("<div class='duration'>Duration: " + Duration + " min</div>");

            if (SolveId == -1 && Applied == 0 && UserCredit >= Cost)
            {
                html.Append("<a href='/Home.aspx?solveProblem=" + Id + "'><div class='button'>Solve $" + Cost + "</div></a>");
            }
            else if (SolveId != -1)
            {
                html.Append("<div class='disabledButton'>Solver is known</div>");
            }
            else if (Applied == 1)
            {
                html.Append("<div class='disabledButton'>Already applied</div>");
            }
            else if (UserCredit < Cost)
            {
                html.Append("<div class='disabledButton'>No enough money $" + Cost + "</div>");
            }

            html.Append("</div>");

            html.Append("<div class='clear'></div>");

            return html.ToString();
        }
    }
}