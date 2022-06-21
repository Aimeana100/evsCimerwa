import { usePage } from "@inertiajs/inertia-react";
import { isArray } from "lodash";
import React from "react";

const TableRow = (v) => {
    const { vistors, taps } = usePage().props;

    const {
        data,
        meta: { links },
    } = vistors;

    var ArrSorted = [];

    var createDateString = (dates) => {
        var dates =
            new Date(dates).getFullYear() +
            "-" +
            (parseInt(new Date(dates).getMonth()) + 1) +
            "-" +
            new Date(dates).getDate();

        return dates;
    };

    data.forEach((currentVisitor, Index, AllVisitors) => {
        currentVisitor.taps.forEach((CurrentTap, TapIndex, AllVisitoTaps) => {
            if (isArray(ArrSorted[createDateString(CurrentTap.tapped_at)])) {
                ArrSorted[createDateString(CurrentTap.tapped_at)].push(
                    currentVisitor
                );
            } else {
                ArrSorted[createDateString(CurrentTap.tapped_at)] = [
                    currentVisitor,
                ];
            }
        });
    });

    // console.log(ArrSorted);

    for (let item in ArrSorted) {
    //     ArrSorted[item].forEach(({ taps }) => {
    //         taps.forEach(({ tapped_at }) => {
    //           console.log(tapped_at);

    //             if (item == createDateString(tapped_at)) {
                    return <div>TableRow </div>;
        //         }

        //     });
        // });
    }
};

export default TableRow;
