<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Home.aspx.cs" Inherits="Hackathon.Home" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Home</title>
    <link href="design.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form id="home" runat="server">
    <div>
        <!-- Header --->
        <div id="header">
            <div id="headerButtons">
                
                <div class="leftDiv"><a href="/Home.aspx"><div class="headerButton">Teacher</div></a></div>
                <div class="leftDiv"><a href="/Home.aspx?view=student"><div class="headerButton">Student</div></a></div>

                <div class="rightDiv"><a href="/Logout.aspx"><div class="headerButton">Logout</div></a></div>
                <div class="rightDiv"><a href="/Profile.aspx"><div class="headerButton">Profile</div></a></div>

                <div class="clear"></div>
            </div>
        </div>

        <div id="mainDiv">
            <div class="leftDiv">
                <div runat="server" id="list"></div>
            </div>

            <div class="rightDiv">
                <div runat="server" id="createButtonDiv"></div>
                <div runat="server" id="nextSessionLecture"></div>
                <div runat="server" id="nextSessionProblem"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
    </form>
</body>
</html>
