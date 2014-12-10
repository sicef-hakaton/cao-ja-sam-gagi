using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.Web.Security;
using System.Net;
using Hackathon.Classes;
using System.Web.UI.HtmlControls;
using System.Text;

namespace Hackathon
{
    public partial class Home : System.Web.UI.Page
    {
        private const string ServerHttpGetRequestFutureLectures = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/get_future_lectures.php";
        private const string ServerHttpGetRequestFutureProblems = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/get_future_problems.php";
        private const string SuccessMessage = "Success";

        private const string getRequestApplyForLecture = "applyForLecture";
        private const string getHttpRequestApplyForLectureUrl = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/add_participation.php?";

        private const string getRequsetSolveProblem = "solveProblem";
        private const string getHttpRequestSolveProblemUrl = "http://www.caojasamgagi2.site88.net/PHP_HACKATHON/add_solver.php?";

        LinkedList<Lecture> lectures = null;
        LinkedList<Problem> problems = null;

        Lecture closestLecture = null;
        Problem closestProblem = null;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!this.Page.User.Identity.IsAuthenticated)
            {
                FormsAuthentication.RedirectToLoginPage();
            }
            else
            {
                if (Request.Params[getRequestApplyForLecture] != null)
                {
                    ApplyForLecture();
                    Response.Redirect("/Home.aspx?view=student");
                }

                if (Request.Params[getRequsetSolveProblem] != null)
                {
                    SolveProblem();
                    Response.Redirect("/Home.aspx");
                }

                if (lectures == null) GetFutureLectures();
                if (problems == null) GetFutureProblems();

                if (Request.Params["view"] != null && Request.Params["view"].Equals("student"))
                {
                    ShowForStudent();
                    DrawCreateButton("Create new problem", "/PostProblem.aspx");
                }
                else
                {
                    ShowForTeacher();
                    DrawCreateButton("Create new lecture", "/PostLecture.aspx");
                }

                DrawNextSessionProblem();
                DrawNextSessionLecture();
            }
        }

        private void DrawNextSessionLecture()
        {
            if (closestLecture == null)
            {
                LiteralControl literalControl = new LiteralControl();
                literalControl.Text = "<div class='descriptionSide'>You don't have upcoming lectures</div>";
                nextSessionLecture.Controls.Add(literalControl);
            }
            else
            {
                StringBuilder html = new StringBuilder();

                html.Append("<div class='desciptionTitle'>Your next lecture session</div>");
                html.Append("<div class='descriptionSide'>" + closestLecture.Description + "</div>");

                if (closestLecture.Active == 0)
                {
                    html.Append("<div class='disabledButton'>" + closestLecture.BeginTime.ToString("HH:mm") + "&nbsp; &nbsp;" + closestLecture.BeginTime.ToString("dd. MMM yyyy.") + "</div>");
                }
                else
                {
                    html.Append("<a href='/Session.aspx?teacherId=" + closestLecture.TeacherId + "&myId=" + HttpContext.Current.User.Identity.Name + "&myNameString=" + closestLecture.firstNameLastName + "'><div class='button'>Connect</div></a>");
                }

                LiteralControl literalControl = new LiteralControl();
                literalControl.Text = html.ToString();
                nextSessionLecture.Controls.Add(literalControl);
            }
        }

        private void DrawNextSessionProblem()
        {
            if (closestProblem == null)
            {
                LiteralControl literalControl = new LiteralControl();
                literalControl.Text = "<div class='descriptionSide'>You don't have upcoming problems</div>";
                nextSessionProblem.Controls.Add(literalControl);
            }
            else
            {
                StringBuilder html = new StringBuilder();

                html.Append("<div class='desciptionTitle'>Your next lecture problems</div>");
                html.Append("<div class='descriptionSide'>" + closestProblem.Description + "</div>");

                if (closestProblem.Active == 0)
                {
                    html.Append("<div class='disabledButton'>" + closestProblem.BeginTime.ToString("HH:mm") + "&nbsp; &nbsp;" + closestProblem.BeginTime.ToString("dd. MMM yyyy.") + "</div>");
                }
                else
                {
                    html.Append("<a href='/Session.aspx?teacherId=" + closestProblem.SolveId + "&myId=" + HttpContext.Current.User.Identity.Name + "&myNameString=" + closestProblem.firstNameLastName + "'><div class='button'>Connect</div></a>");
                }

                LiteralControl literalControl = new LiteralControl();
                literalControl.Text = html.ToString();
                nextSessionProblem.Controls.Add(literalControl);
            }
        }

        private void DrawCreateButton(string message, string url)
        {
            LiteralControl literalControl = new LiteralControl();
            literalControl.Text = "<a href='" + url + "'><div class='createButton'>" + message + "</div></a>";

            createButtonDiv.Controls.Add(literalControl);
        }

        private void SolveProblem()
        {
            WebClient webClient = new WebClient();

            StringBuilder url = new StringBuilder(getHttpRequestSolveProblemUrl);
            url.Append("solver_id=" + HttpContext.Current.User.Identity.Name);
            url.Append("&problem_id=" + Request.Params[getRequsetSolveProblem]);

            webClient.DownloadString(url.ToString());
        }

        private void ApplyForLecture()
        {
            WebClient webClient = new WebClient();

            StringBuilder url = new StringBuilder(getHttpRequestApplyForLectureUrl);
            url.Append("student_id=" + HttpContext.Current.User.Identity.Name);
            url.Append("&lecture_id=" + Request.Params[getRequestApplyForLecture]);

            webClient.DownloadString(url.ToString());
        }

        private void GetFutureProblems()
        {
            problems = new LinkedList<Problem>();

            WebClient webclient = new WebClient();
            string result = webclient.DownloadString(Home.ServerHttpGetRequestFutureProblems.ToString() + "?id=" + HttpContext.Current.User.Identity.Name);
            dynamic json = Functions.getJson(result);

            if (json.problems != null)
            {
                foreach (dynamic jsonProblem in json.problems)
                {
                    Problem problem = new Problem();
                    problem.Id = Convert.ToInt32((string)jsonProblem.problem_id);
                    problem.BeginTime = Functions.calculateReverseTime(Convert.ToInt64((string)jsonProblem.begin_time));
                    problem.Duration = Convert.ToInt32((string)jsonProblem.duration) / 60;

                    problem.PosterId = Convert.ToInt32((string)jsonProblem.poster_id);
                    problem.PosterEmail = (string)jsonProblem.poster_email;
                    problem.PosterFirstName = (string)jsonProblem.poster_first_name;
                    problem.PosterLastName = (string)jsonProblem.poster_last_name;

                    problem.Cost = Convert.ToInt32((string)jsonProblem.cost);
                    problem.Description = (string)jsonProblem.description;

                    problem.SolveId = Convert.ToInt32((string)jsonProblem.solver_id);

                    // there is solver
                    if (problem.SolveId != -1)
                    {
                        problem.SolverEmail = (string)jsonProblem.solver_email;
                        problem.SolverFirstName = (string)jsonProblem.solver_first_name;
                        problem.SolverLastName = (string)jsonProblem.solver_last_name;
                    }

                    problem.UserCredit = Convert.ToInt32(json.credit);
                    problem.Applied = Convert.ToInt32(jsonProblem.me);
                    problem.Active = jsonProblem.active;
                    problem.firstNameLastName = json.first_name + " " + json.last_name;

                    problems.AddLast(problem);

                    if (problem.SolveId == Convert.ToInt32(HttpContext.Current.User.Identity.Name) && closestProblem == null)
                    {
                        closestProblem = problem;
                    }
                }
            }
        }

        private void GetFutureLectures()
        {
            lectures = new LinkedList<Lecture>();

            WebClient webclient = new WebClient();
            string result = webclient.DownloadString(Home.ServerHttpGetRequestFutureLectures.ToString() + "?id=" + HttpContext.Current.User.Identity.Name);
            dynamic json = Functions.getJson(result);

            if (json.lectures != null)
            {
                foreach (dynamic jsonLecture in json.lectures)
                {
                    Lecture lecture = new Lecture();
                    lecture.Id = Convert.ToInt32((string)jsonLecture.lecture_id);
                    lecture.BeginTime = Functions.calculateReverseTime(Convert.ToInt64((string)jsonLecture.begin_time));
                    lecture.Duration = Convert.ToInt32((string)jsonLecture.duration) / 60;
                    lecture.TeacherId = Convert.ToInt32((string)jsonLecture.teacher_id);
                    lecture.TeacherEmail = (string)jsonLecture.teacher_email;
                    lecture.TeacherFirstName = (string)jsonLecture.teacher_first_name;
                    lecture.TeacherLastName = (string)jsonLecture.teacher_last_name;
                    lecture.Cost = Convert.ToInt32((string)jsonLecture.cost);
                    lecture.MaxUsers = Convert.ToInt32((string)jsonLecture.max_users);
                    lecture.Description = (string)jsonLecture.description;
                    lecture.NumberOfParticipants = Convert.ToInt32((string)jsonLecture.n_part);

                    lecture.UserCredit = Convert.ToInt32(json.credit);
                    lecture.Applied = Convert.ToInt32(jsonLecture.me);
                    lecture.Active = jsonLecture.active;
                    lecture.firstNameLastName = json.first_name + " " + json.last_name;

                    lectures.AddLast(lecture);

                    if ((lecture.TeacherId == Convert.ToInt32(HttpContext.Current.User.Identity.Name) || lecture.Applied == 1) && closestLecture == null)
                    {
                        closestLecture = lecture;
                    }
                }
            }
        }

        protected void Logout(object sender, EventArgs e)
        {
            FormsAuthentication.SignOut();
            Response.Redirect("Home.aspx", true);
        }

        protected void ShowTeacher(object sender, EventArgs e)
        {
            ShowForTeacher();
        }

        protected void ShowStudent(object sender, EventArgs e)
        {
            ShowForStudent();
        }

        protected void ShowForTeacher()
        {
            list.Controls.Clear();
            foreach (var problem in problems)
            {
                if (problem.Active == 0)
                {
                    LiteralControl problemDiv = new LiteralControl();
                    problemDiv.Text += "<div class='lecture'>";
                    problemDiv.Text += problem.ToString();
                    problemDiv.Text += "</div>";

                    list.Controls.Add(problemDiv);
                }
            }
        }

        protected void ShowForStudent()
        {
            list.Controls.Clear();
            foreach (var lecture in lectures)
            {
                if (lecture.Active == 0)
                {
                    LiteralControl lectureDiv = new LiteralControl();
                    lectureDiv.Text += "<div class='lecture'>";
                    lectureDiv.Text += lecture.ToString();
                    lectureDiv.Text += "</div>";

                    list.Controls.Add(lectureDiv);
                }
            }
        }

        protected void RedirectProfile(object sender, EventArgs e)
        {
            Response.Redirect("/Profile.aspx");
        }


    }
}