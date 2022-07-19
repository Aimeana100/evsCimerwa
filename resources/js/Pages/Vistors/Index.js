import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout, { DataContext, getTapsFiltered } from "@/Layouts/Layout";
import React, { Component, useContext, useEffect, useState } from "react";
import { Icon, Label } from "@material-tailwind/react";
import { create, isArray } from "lodash";
import { usePrevious } from "react-use";
import LazyLoad from "react-lazy-load";

class TableComponent extends Component {
    render() {
        var body = this.props.data;
        var tableTitle = this.props.tableTitle;
        var heading = [
            "#",
            "Names",
            "Phone",
            "NID",
            "Gender",
            "Movement",
            "Time-Range",
        ];

        function containsSpecialChars(str) {
            const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
            if (str) return specialChars.test(str) || str.length > 15;
            else return specialChars.test(str);
        }

        return (
            <div className="overflow-x-auto bg-white rounded shadow border-2">
                <h1 className="text-center px-6 bg-slate-400 py-[1px] text-[26px] font-bold">
                    {" "}
                    {tableTitle}{" "}
                </h1>
                <table className="w-full whitespace-nowrap mb-3 mx-2 pb-4">
                    <thead>
                        <tr className="font-bold text-left">
                            {heading.map((head, key) => (
                                <th key={key}>{head}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {body.map((row, index) => {
                            return (
                                //    <TableRow key={index} row={row} />

                                <tr className="hover:bg-gray-100 focus-within:bg-gray-100 py-2">
                                    <td className="border-t text-[12px]">
                                        {row.id}
                                    </td>
                                    <td className="border-t text-[12px]">
                                        {row.names}
                                    </td>
                                    <td className="border-t text-[12px]">
                                        {!containsSpecialChars(row.phone) &&
                                            row.phone}
                                    </td>
                                    <td className="border-t text-[12px]">
                                        {row.ID_Card}
                                    </td>
                                    <td className="border-t text-[12px]">
                                        {row.gender}
                                    </td>
                                    <td className="border-t text-[12px]">
                                        <Taps taps={row.taps} />
                                    </td>
                                    <td className="border-t text-[12px]">
                                        {tap(row.taps)}
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>
        );
    }
}

function tap(tp) {
    let i = 0;
    let diffMinutes = [];
    if (tp[0].status == "ENTERING" && tp.length % 2 == 0) {
        while (i < tp.length) {
            var tp2 = new Date(tp[i + 1].tapped_at);
            var tp1 = new Date(tp[i].tapped_at);
            diffMinutes.push(
                Math.round((tp2.getTime() - tp1.getTime()) / (1000 * 60))
            );
            i += 2;
        }
    }
    return (
        <>
            <div> {0 || diffMinutes.map((e) => <div> {e} min</div>)} </div>
            <hr />
            <span className="rounded block w-fit p-[1px] bg-red-200 text-black font-mono">
                {" "}
                {diffMinutes.reduce((acc, el) => acc + el, 0)}{" "}
            </span>
        </>
    );
}

class TapsRow extends Component {
    render() {
        var rows = this.props.taprow;

        const { ENTERING, EXITING } = rows;

        const getL = (dt) => {
            const { ENTERING, EXITING } = dt;

            if (typeof ENTERING == "undefined") {
                return EXITING;
            } else if (typeof EXITING == "undefined") {
                return ENTERING;
            } else {
                return ENTERING.length > EXITING.length ? ENTERING : EXITING;
            }
        };

        // console.log(date_diff_indays(rows));

        var largeArr = getL(rows);

        return largeArr.map((item, index) => {
            return (
                <tr className="relative" key={index}>
                    {typeof ENTERING != "undefined" && typeof ENTERING[index] && (
                        <td className="relative bg-zinc-200  border border-red-100 rounded-2 bg-gradient-to-r from-zinc-200 to-zinc-400 ">
                            <span className="relative pr-1 text-[11px]">
                                <span className="absolute rounded-full w-[5px] h-[5px] mx-1  bg-blue-700 -right-1 -top-[1/2]"></span>
                                {ENTERING[index]}
                            </span>
                        </td>
                    )}

                    {typeof EXITING != "undefined" && typeof EXITING[index] && (
                        <td className="relative ml-1 bg-gradient-to-r  from-blue-300 to-blue-100">
                            <span className="relative pr-1 text-[11px]">
                                <span className="absolute rounded-full w-[5px] h-[5px] mx-1  bg-green-700 -right-1 -bottom-1"></span>

                                {EXITING[index]}
                            </span>
                        </td>
                    )}
                </tr>
            );
        });
    }
}

class Taps extends Component {
    render() {
        var createDateString = (dates) => {
            var date = new Date(dates); //M-D-YYYY;
            var mm = date.getMinutes();
            var hh = date.getHours();

            var dateString =
                (hh <= 9 ? "0" + hh : hh) + ":" + (mm <= 9 ? "0" + mm : mm);

            return dateString;
        };

        var taps = this.props.taps;

        // console.log(taps);

        var neObj = taps.reduce((prv, curr) => {
            var key = curr.status;
            if (!prv[key]) {
                prv[key] = [];
            }

            prv[key].push(createDateString(curr.tapped_at));
            return prv;
        }, {});

        const { ENTERING, EXITING } = neObj;

        const getL = (dt) => {
            const { ENTERING, EXITING } = dt;

            if (typeof ENTERING == "undefined") {
                return EXITING;
            } else if (typeof EXITING == "undefined") {
                return ENTERING;
            } else {
                return ENTERING.length > EXITING.length ? ENTERING : EXITING;
            }
        };

        return (
            <table>
                <tbody className="grid grid-cols-1 divide-red-800 divide-y">
                    <TapsRow timeRange={4} taprow={neObj} />
                </tbody>
            </table>
        );
    }
}

const Index = () => {
    const { vistors, taps, filters } = usePage().props;
    const {
        data,
        meta: { links },
    } = vistors;

    const orderedData = getTapsFiltered(data);

    const [values, setValues] = useState({
        searchFrom: filters.searchFrom || "",
        selected: filters.selected || "",
    });

    const [vistorsData, setVisitorsData] = useState([]);

    const prevValues = usePrevious(values);

    function handleChange(e) {

        const key = e.target.name;
        const value = e.target.value;

        setValues((values) => ({
            ...values,
            [key]: value,
        }));
        // if (opened) setOpened(false);
    }

    useEffect(() => {
        // https://reactjs.org/docs/hooks-faq.html#how-to-get-the-previous-props-or-state

        if (prevValues) {

            // if (values.searchFrom != "" && vistorsData.filter((elF, i) => elF.date == values.searchFrom).length != 0) {
            // }

                if (values.selected == "inGate") {
                const visitorIn = orderedData.map((el, index) => {
                    return {
                        ...el,
                        records: el.records.filter(
                            (elementToFilter) => elementToFilter.status == "IN"
                        ),
                    };
                });

                setVisitorsData(visitorIn);

                return;
            } else if (values.selected == "outGate") {
                const visitorOut = orderedData.map((el, index) => {
                    return {
                        ...el,
                        records: el.records.filter(
                            (elementToFilter) => elementToFilter.status == "OUT"
                        ),
                    };
                });
                setVisitorsData(visitorOut);
                return;
            }

            if (values.searchFrom != "" && orderedData.filter((elF, i) => elF.date == values.searchFrom).length != 0) {
                const visitorDate = orderedData.filter((elM, index) => {
                    return elM.date == values.searchFrom;
                });
                setVisitorsData(visitorDate);
                return;
            } 
            // else {
            //     setVisitorsData(orderedData);
            //     return;
            // }
        } else {
            setVisitorsData(orderedData);
        }
    }, [values]);

    return (
        <>
            <div className="md:ml-64 pt-10">
                <h1 className="mb-8 text-3xl font-bold">Vistors </h1>
                <div className="flex items-center justify-between mb-6">
                    <div className="flex items-center w-full justify-between mb-6">
                        <div className="flex justify-between align-baseline flex-col md:flex-row p-2 rounded-md bg-slate-300 w-full ">
                            <div className="flex bg-[#dddde7ee] p-2 w-60">
                                <Label
                                    color="primary"
                                    className="bg-[#dcdceeee] rounded-none px-20 "
                                >
                                    Filter
                                </Label>
                                <select
                                    value={values.selected}
                                    name="selected"
                                    onChange={handleChange}
                                    className="w-lg-50 p-1 w-full bg-slate-100 border-0 text-[13px] "
                                >
                                    <option
                                        value=""
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        All Vistors
                                    </option>
                                    <option
                                        value="inGate"
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        In-Gate
                                    </option>

                                    <option
                                        value="outGate"
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        Out-Gate
                                    </option>
                                </select>
                            </div>


                            <div className="flex bg-[#dddde7ee] p-2 flex-1 justify-end">
                                <div className="flex md:flex-col flex-row min-w-fit border bg-slate-200 py-1 px-3">
                                    <Label
                                        color="primary"
                                        for="search"
                                        className="bg-slate-200 px-2 md:px-18 "
                                    >
                                        Shifts
                                    </Label>

                                    <select
                                    value={values.shifts}
                                    name="shifts"
                                    // onChange={handleChange}

                                    className="w-lg-50 p-1 w-full bg-slate-100 border-0 text-[13px]"
                                    >
                                    <option
                                        value=""
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        All Vistors
                                    </option>

                                    <option
                                        value="inGate"
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        Shifts 1
                                    </option>

                                    <option
                                        value="outGate"
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        Shifts 2
                                    </option>

                                    <option
                                        value="outGate"
                                        className="p-1 md:py-2 md:px-2 text-[12px]"
                                    >
                                        Shifts 3
                                    </option>

                                </select>

                                </div>
                            </div>


                            <div className="flex bg-[#dddde7ee] p-2 flex-1 justify-end self-end">
                                <div className="flex w-fit border bg-slate-200 rounded-full py-1 px-3 ">
                                    <Label
                                        color="primary"
                                        for="search"
                                        className="bg-slate-200 px-2 md:px-20 "
                                    >
                                        On Date
                                    </Label>

                                    <input
                                        autoComplete="off"
                                        type="date"
                                        name="searchFrom"
                                        value={values.searchFrom}
                                        onChange={handleChange}
                                        className="bg-slate-200 p-1 rounded-full"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {vistorsData.map((item, index, arr) => {
                    return (
                        <div>

                                <TableComponent
                                    data={item.records}
                                    tableTitle={item.date}
                                    key={index}
                                />
                        </div>
                    );
                })}
            </div>
        </>
    );
};

Index.layout = (page) => <Layout title="Users" children={page} />;
export default Index;
