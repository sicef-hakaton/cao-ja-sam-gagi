<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Register.aspx.cs" Inherits="Hackathon.Register" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Register</title>
    <link href="design.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form id="Form2" runat="server">
    <div>
        <div id="header">
            <div id="headerButtons">
            </div>
        </div>

        <div id="mainDiv">
            <div class="loginContainer">

                <div class="lecture">
                    <div class="desciptionTitle">Register</div>

                    <div class="description">
                        <table class="inputTable" style="width:550px;">
                            <tr>
                                <td>Email</td>
                                <td><asp:TextBox ID="email" runat="server" /></td>
                                <td>
                                    <asp:RequiredFieldValidator ErrorMessage="Required" Display="Dynamic" ForeColor="Red"
                                    ControlToValidate="email" runat="server" />
                                    <asp:RegularExpressionValidator runat="server" Display="Dynamic" ValidationExpression="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"
                                    ControlToValidate="email" ForeColor="Red" ErrorMessage="Invalid email address." />
                                </td>
                            </tr>

                            <tr>
                                <td>Password</td>
                                <td><asp:TextBox TextMode="Password" ID="password" runat="server" /></td>
                                <td><asp:RequiredFieldValidator ErrorMessage="Required" ForeColor="Red" ControlToValidate="password" runat="server" /></td>
                            </tr>

                            <tr>
                                <td>Retype password</td>
                                <td><asp:TextBox TextMode="Password" ID="confirmPassword" runat="server" /></td>
                                <td><asp:CompareValidator ErrorMessage="Passwords do not match." ForeColor="Red" ControlToCompare="password" ControlToValidate="confirmPassword" runat="server" /></td>
                            </tr>

                            <tr>
                                <td>First name</td>
                                <td><asp:TextBox ID="firstName" runat="server" /></td>
                            </tr>

                            <tr>
                                <td>Last name</td>
                                <td><asp:TextBox ID="lastName" runat="server" /></td>
                            </tr>

                            <tr>
                                <td colspan="3"><asp:Label ID="failureMessage" runat="server"/></td>
                            </tr>
                        </table>

                        <asp:Button Width="100px" class="button" ID="Register1" Text="Register" OnClick="RegisterUser" runat="server" />
                    </div>
                </div>
             </div>
        </div>
    </div>
    </form>
</body>
</html>
