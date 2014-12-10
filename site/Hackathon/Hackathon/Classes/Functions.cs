using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Helpers;

namespace Hackathon.Classes
{
    public class Functions
    {
        public static string calculateTime(string date, string time)
        {
            int day = Convert.ToInt32(date.Split('.').ElementAt(0));
            int month = Convert.ToInt32(date.Split('.').ElementAt(1));
            int year = Convert.ToInt32(date.Split('.').ElementAt(2));

            int hour = Convert.ToInt32(time.Split(':').ElementAt(0));
            int minute = Convert.ToInt32(time.Split(':').ElementAt(1));
            int second = 0;

            DateTime dateTime = new DateTime(year, month, day, hour, minute, second);
            return (Convert.ToInt32((dateTime - new DateTime(1970, 1, 1, 0, 0, 0, 0).ToLocalTime()).TotalSeconds)).ToString();
        }

        public static DateTime calculateReverseTime(long seconds)
        {
            System.DateTime dtDateTime = new DateTime(1970, 1, 1, 0, 0, 0, System.DateTimeKind.Utc);
            dtDateTime = dtDateTime.AddSeconds(seconds).ToLocalTime();
            return dtDateTime;
        }

        public static dynamic getJson(string str)
        {
            int beginOfJSON = str.IndexOf('{');
            int endOfJSON = str.LastIndexOf('}');
            str = str.Substring(beginOfJSON, endOfJSON - beginOfJSON + 1);

            return Json.Decode(str);
        }
    }
}