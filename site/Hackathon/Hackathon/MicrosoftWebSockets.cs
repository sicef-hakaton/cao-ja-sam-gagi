using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading;
using System.Web;
using Microsoft.Web.WebSockets;
namespace Hackathon
{
    public class MicrosoftWebSockets : WebSocketHandler
    {
        private static WebSocketCollection clients = new WebSocketCollection();
        private string name;
        private static string color = "black";

        public override void OnOpen()
        {
            this.name = this.WebSocketContext.QueryString["name"];
            clients.Add(this);
            clients.Broadcast("3" + name + " has connected.");
        }

        public override void OnMessage(string message)
        {
            // 0 - msg
            // 1 - draw
            // 2 - give control
            // 3 - new user has connected
            // 4 - change color
            switch (message[0])
            {
                case '1':
                    clients.Broadcast(string.Format("1findxy2({0}, \"{1}\");", message.Substring(1), color));
                    break;
                case '0':
                case '3':
                    clients.Broadcast(string.Format("{0}", message));
                    break;
                case '4':
                    color = message.Substring(1);
                    break;
            }
        }

        public override void OnClose()
        {
            clients.Remove(this);
            clients.Broadcast(string.Format("{0} has gone away.", name));
        }

    }
}