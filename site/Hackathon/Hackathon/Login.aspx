<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Login.aspx.cs" Inherits="Hackathon.Login" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Login</title>
    <link href="design.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form id="Form1" runat="server">
    <div>
        <div id="header">
            <div id="headerButtons">
            </div>
        </div>

        <div id="mainDiv">
            <div class="loginContainer">

                <div class="lecture">
                    <div class="desciptionTitle">Login</div>

                    <div class="description">
                        <table class="inputTable">
                            <tr>
                                <td>Email</td>
                                <td>
                                    <asp:TextBox ID="email" runat="server" /></td>
                                <td>
                                    <asp:RequiredFieldValidator ErrorMessage="Required" Display="Dynamic" ForeColor="Red"
                                        ControlToValidate="email" runat="server" />
                                    <asp:RegularExpressionValidator runat="server" Display="Dynamic" ValidationExpression="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"
                                        ControlToValidate="email" ForeColor="Red" ErrorMessage="Invalid email address." />
                                </td>
                            </tr>

                            <tr>
                                <td>Password</td>
                                <td>
                                    <asp:TextBox TextMode="Password" ID="password" runat="server" /></td>
                                <td>
                                    <asp:RequiredFieldValidator ErrorMessage="Required" ForeColor="Red" ControlToValidate="password" runat="server" /></td>
                            </tr>


                            <tr>
                                <td colspan="3">
                                    <asp:Label ForeColor="Red" ID="failureMessage" runat="server" /></td>
                            </tr>
                        </table>

                        <asp:Button ID="login" class="button" Text="Login" runat="server" OnClick="ValidateUser" />
                        <asp:Button CausesValidation="false" class="button" ID="Register1" Text="Register" OnClick="RegisterPage" runat="server" />
                    </div>
                </div>
             </div>
        </div>
    </div>
    </form>
</body>
</html>
