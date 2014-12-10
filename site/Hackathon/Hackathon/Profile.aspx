<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Profile.aspx.cs" Inherits="Hackathon.Profile" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Profile</title>
    <link href="design.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form id="Form2" runat="server">
    <div>
        <div id="header">
            <div id="headerButtons">
                <div class="leftDiv"><a href="/Home.aspx"><div class="headerButton">Teacher</div></a></div>
                <div class="leftDiv"><a href="/Home.aspx?view=student"><div class="headerButton">Student</div></a></div>

                <div class="rightDiv"><a href="/Logout.aspx"><div class="headerButton">Logout</div></a></div>
                <div class="rightDiv"><a href="/Profile.aspx"><div class="headerButton">Profile</div></a></div>

                <div class="clear"></div>
            </div>
        </div>

        <div id="mainDiv" align="center">
                <div id="userData" runat="server"></div>
        </div>
    </div>
    </form>
</body>
</html>
