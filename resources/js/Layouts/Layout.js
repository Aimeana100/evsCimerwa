import React, { useState } from "react";
import Sidebar from "@/AppComponents/Sidebar";
import AdminNavbar from "@/AppComponents/AdminNavbar";
import { usePage } from "@inertiajs/inertia-react";
import { create, isArray } from "lodash";



export const createDateString = (dates) => {
    var date =
   (String(new Date(dates).getFullYear())) +
        "-" +
        (String((parseInt(new Date(dates).getMonth()) + 1) < 10) ? ("0" + String(parseInt(new Date(dates).getMonth()) + 1)) : String(parseInt(new Date(dates).getMonth()) + 1)) +
        "-" +
        ((parseInt(new Date(dates).getDate())< 10)  ? ("0"+ String(new Date(dates).getDate())) : (String(new Date(dates).getDate())) );

    return date;
};


const organizeDaily = (mixed_records) => {
    var ArrSorted = [];

    mixed_records.forEach((currentVisitor) => {
        currentVisitor.taps.forEach((CurrentTap) => {
            isArray(ArrSorted[createDateString(CurrentTap.tapped_at)])
                ? ArrSorted[createDateString(CurrentTap.tapped_at)].push(
                      currentVisitor
                  )
                : (ArrSorted[createDateString(CurrentTap.tapped_at)] = [
                      currentVisitor,
                  ]);
        });
    });

    for (const el in ArrSorted) {
        ArrSorted[el] = Array.from(new Set(ArrSorted[el]));
    }

    return ArrSorted;
};


// filter and organize the data

export const getTapsFiltered = (unifiltered) => {

    var taps_filtered = [];
    var organized = organizeDaily(unifiltered);



    for (var key_day in organized) {
        taps_filtered.push({
            date: key_day,
            records: organized[key_day].map((e, i) => {
                return {
                    ...e,
                    taps: e.taps.filter(
                        (t) => createDateString(t.tapped_at) == key_day
                    ),
                };
            }),
        });
    }

    return taps_filtered;

}

function Layout({ title, children }) {

    const [showSidebar, setShowSidebar] = useState("-left-64");

    return (
        <div>
            <AdminNavbar
                showSidebar={showSidebar}
                setShowSidebar={setShowSidebar}
            />
            <Sidebar
                showSidebar={showSidebar}
                setShowSidebar={setShowSidebar}
            />
            
            <div className="mx-1 p-2">{children}</div>
        </div>
    );
}

export default Layout;
