import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout, { createDateString, getTapsFiltered } from "@/Layouts/Layout";
import React, { useState, useEffect, Component } from "react";
import { Button, ClosingAlert, Icon } from "@material-tailwind/react";
import { usePrevious } from "react-use";
import Label from "@/Components/Label";
import pickBy from "lodash/pickBy";
import { Inertia } from "@inertiajs/inertia";
import { show_tap_formated } from "../Vistors/Index";

import Image from "@material-tailwind/react/Image";
import ProfilePicture from "../../assets/images/user.png";

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
                <tr className="relative" key={index} >
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

const Index = () => {
    const { employees, taps, filters, flash } = usePage().props;
    const {
        data,
        meta: { links },
    } = employees;

    const orderedData = getTapsFiltered(data);

        console.log(data);

    // console.log(orderedData.filter((el,i)=>{return el.date == createDateString(new Date())}));

    const [values, setValues] = useState({
        onDate: filters.onDate || createDateString(new Date()),
        selected: filters.selected || "",
        // shifts: filters.shifts || "",
        searchMatch: filters.searchMatch || "",
    });

    const [filterDate, setfilterDate] = useState(createDateString(new Date()));
    const [employeeData, setEmployeeData] = useState([]);

    const shifts = {
        sh1: { from: 8, to: 13 },
        sh2: { from: 13, to: 21 },
        sh3: { from: 21, to: 23 },
    };

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

    function handleChangeSearch(e) {
        const key = e.target.name;
        const value = e.target.value;

        setValues((values) => ({
            ...values,
            searchMatch: value,
        }));
        // if (opened) setOpened(false);
    }

    useEffect(() => {
        if (prevValues) {
            // console.log("here");
            // if (values.searchFrom != "" && vistorsData.filter((elF, i) => elF.date == values.searchFrom).length != 0) {
            // }
            if (values.selected == "banned") {
                const visitorIn = orderedData
                    .filter((el, i) => {
                        return (
                            el.date ==
                            createDateString(values.onDate).toString()
                        );
                    })
                    .map((el, index) => {
                        return {
                            ...el,
                            records: el.records.filter(
                                (elementToFilter) =>
                                    elementToFilter.state == false
                            ),
                        };
                    });

                setEmployeeData(visitorIn);
                return;
            } else if (values.selected == "activated") {
                const visitorOut = orderedData
                    .filter((el, i) => {
                        return (
                            el.date ==
                            createDateString(values.onDate).toString()
                        );
                    })
                    .map((el, index) => {
                        return {
                            ...el,
                            records: el.records.filter(
                                (elementToFilter) =>
                                    elementToFilter.state == true
                            ),
                        };
                    });
                setEmployeeData(visitorOut);
                return;
            } else if (values.selected == "inGate") {
                const visitorOut = orderedData
                    .filter((el, i) => {
                        return (
                            el.date ==
                            createDateString(values.onDate).toString()
                        );
                    })
                    .map((el, index) => {
                        return {
                            ...el,
                            records: el.records.filter(
                                (elementToFilter) =>
                                    elementToFilter.status == "IN"
                            ),
                        };
                    });
                setEmployeeData(visitorOut);
                return;
            }
            // console.log(values, "dayc");

            if (values.onDate != "") {
                if (
                    orderedData.filter((elF, i) => elF.date == values.onDate)
                        .length != 0
                ) {
                    // const visitorDate = orderedData.filter((elM, index) => {
                    //     return elM.date == values.onDate;
                    // });
                    setEmployeeData(
                        orderedData.filter((el, i) => {
                            return (
                                el.date ==
                                createDateString(values.onDate).toString()
                            );
                        })
                    );
                    return;
                }
                // else {
                //     setValues((values) => ({
                //         ...values,
                //         onDate: createDateString(new Date()),
                //     }));
                // }
            }
        }
        //  else {
        // setValues((values) => ({
        //     ...values,
        //     onDate: createDateString(new Date()),
        // }));
        
        const toDay = orderedData.filter((el, i) => {
            return el.date == createDateString(new Date()).toString();
        });
        // setEmployeeData(toDay);

        setEmployeeData(orderedData);

        // }

    }, [values]);

    console.log(employeeData, values);

    const shift1 = orderedData
        .filter((el, i) => {
            return el.date == createDateString(values.onDate).toString();
        })
        .map((todaysEl, id) => {
            return {
                ...todaysEl,
                records: todaysEl.records.filter((el, i) => {
                    el.taps.filter(
                        (tapEl) =>
                            new Date(tapEl.tapped_at).getHours >
                                shifts.sh1.from &&
                            new Date(tapEl.tapped_at).getHours < shifts.sh1.to
                    );
                }),
            };
        });

    const shift2 = orderedData
        .filter((el, i) => {
            return el.date == createDateString(values.onDate).toString();
        })
        .map((todaysEl, id) => {
            return {
                ...todaysEl,
                records: todaysEl.records.filter((el, i) => {
                    el.taps.filter(
                        (tapEl) =>
                            new Date(tapEl.tapped_at).getHours >
                                shifts.sh2.from &&
                            new Date(tapEl.tapped_at).getHours < shifts.sh.to
                    );
                }),
            };
        });

    const shift3 = orderedData
        .filter((el, i) => {
            return el.date == createDateString(values.onDate).toString();
        })
        .map((todaysEl, id) => {
            return {
                ...todaysEl,
                records: todaysEl.records.filter((el, i) => {
                    el.taps.filter(
                        (tapEl) =>
                            new Date(tapEl.tapped_at).getHours >
                                shifts.sh3.from &&
                            new Date(tapEl.tapped_at).getHours < shifts.sh3.to
                    );
                }),
            };
        });

    const shif = orderedData.filter((el, i) => {
        return el.date == createDateString(values.onDate).toString();
    })[0];




    //    const shift4 = {shif, records:shif.records};
    console.log(employeeData);

    return (
        <>
            <div className="md:ml-64 pt-2">
                {/* <h1 className="mb-8 text-3xl font-bold">Employees</h1> */}
                <div className="flex items-center w-full justify-between mb-6">
                    {/* serarch filter */}

                    <div className="flex justify-between align-baseline flex-col md:flex-row flex-lg-row p-2 rounded-md bg-slate-300 w-full ">
                        <div className="flex justify-center items-center  p-2 w-60"></div>

                        <div className="flex justify-center items-center  p-2 w-80"></div>

                        <div className="flex p-2 flex-1 items-center justify-end ">
                            <div className="flex w-fit border bg-slate-200 rounded-full py-1 px-3 ">
                                <Label
                                    for="search"
                                    className="bg-slate-200 px-2 md:px-20 "
                                >
                                    Date
                                </Label>

                                <input
                                    autoComplete="off"
                                    type="date"
                                    name="onDate"
                                    value={values.onDate}
                                    onChange={handleChange}
                                    className="bg-slate-200 p-1 rounded-full"
                                />
                            </div>
                        </div>

                        {/*
                        // <div className="flex p-0 md:p-2 flex-1 justify-end self-end">
                        //     <div className="flex w-fit border bg-slate-200 rounded-full py-1 px-3 ">
                        //         <Label
                        //             for="search"
                        //             className="bg-slate-200 px-20 hidden md:inline"
                        //         >
                        //             Search
                        //         </Label>

                        //         <input
                        //             autoComplete="on"
                        //             type="text"
                        //             name="searchMatch"
                        //             value={values.searchMatch}
                        //             onChange={handleChangeSearch}
                        //             className="bg-slate-200 px-1 md:p-1 rounded-full"
                        //         />
                        //     </div>
                        // </div> */}
                    </div>
                </div>

                {flash.success && (
                    <ClosingAlert color="teal">{flash.success}</ClosingAlert>
                )}

        
                <div className="overflow-x-auto bg-white rounded shadow">
                    <div className="flex items-center w-full justify-center">
                        <div className="max-w-xs">
                            <div className="bg-white shadow-xl rounded-lg py-3">
                               
                                <div className="photo-wrapper p-2">
                                    {/* <img className="w-32 h-32 rounded-full mx-auto" src="https://www.gravatar.com/avatar/2acfb745ecf9d4dccb3364752d17f65f?s=260&d=mp" alt="John Doe"> */}
                                    <div className="w-12">
                                        <Image src={ProfilePicture} rounded />
                                    </div>
                                </div>

                                <div className="p-2">
                                    <h3 className="text-center text-xl text-gray-900 font-medium leading-8">
                                       { data[0].names }
                                    </h3>
                                    <div className="text-center text-gray-400 text-xs font-semibold">
                                        <p>
                                       { data[0]?.email }

                                        </p>
                                    </div>
                                    <table className="text-xs my-3">
                                        <tbody>
                                            <tr>
                                                <td className="px-2 py-2 text-gray-500 font-semibold">
                                                    ID card
                                                </td>
                                                <td className="px-2 py-2">
                                                { data[0]?.ID_Card }
                                                </td>
                                            </tr>
                                            <tr>
                                                <td className="px-2 py-2 text-gray-500 font-semibold">
                                                    Category
                                                </td>
                                                <td className="px-2 py-2">
                                                    
                                                { data[0]?.category }

                                                </td>
                                            </tr>
                                            <tr>
                                                <td className="px-2 py-2 text-gray-500 font-semibold">
                                                    Phone
                                                </td>
                                                <td className="px-2 py-2">
                                                { data[0]?.phone }
                                                </td>
                                            </tr>

                                            <tr>
                                                <td className="px-2 py-2 text-gray-500 font-semibold">
                                                    Last tap
                                                </td>
                                                <td className="px-2 py-2">
                                                { data[0]?.latestTap }
                                                </td>
                                            </tr>

                                            <tr>
                                                <td className="px-2 py-2 text-gray-500 font-semibold">
                                                    Status
                                                </td>
                                                <td className="px-2 py-2">
                                                    { data[0]?.state == 1 ? "Active" : "Inactive" }
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                        </div>
                    </div>

                    <table className="w-full whitespace-nowrap">
                        <thead>
                            <tr className="font-bold text-left">
                                <th className="px-6 pt-5 pb-4">Names</th>
                                <th className="px-6 pt-5 pb-4">ID card</th>
                                <th className="px-6 pt-5 pb-4">Telphone</th>
                                <th className="px-6 pt-5 pb-4">Gender</th>
                                <th className="px-6 pt-5 pb-4">Category</th>
                                <th className="px-6 pt-5 pb-4">Movement </th>
                                <th className="px-6 pt-5 pb-4">Time-Range</th>
                            </tr>
                        </thead>
                        <tbody>
                            {employeeData[0]?.records &&
                                employeeData[0]?.records.map(
                                    ({
                                        id,
                                        names,
                                        phone,
                                        ID_Card,
                                        gender,
                                        state,
                                        category,
                                        taps,
                                    }) => {
                                        return (
                                            <tr
                                                key={id}
                                                className="hover:bg-gray-100 {'bg-red-200' || state == true} focus-within:bg-gray-100"
                                            >
                                                <td className="border-t">
                                                    {names}
                                                </td>
                                                <td className="border-t ">
                                                    {ID_Card}
                                                </td>

                                                <td className="border-t">
                                                    {phone}
                                                </td>
                                                <td className="border-t">
                                                    {gender}
                                                </td>
                                                <td className="border-t">
                                                    {category}
                                                </td>
                                                <td className="border-t text-[12px]">
                                                    <Taps taps={taps} />
                                                </td>
                                                <td className="border-t">
                                                    {show_tap_formated(taps)}
                                                </td>
                                            </tr>
                                        );
                                    }
                                )}

                            {employeeData.length == 0 && (
                                <tr className="text-center">
                                    {" "}
                                    <td className="bg-blue-200" colSpan={7}>
                                        No data for {values.onDate}
                                    </td>{" "}
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
            {/* <div className="bg-red-100 absolute  z-10 w-screen">
                    <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <h1>Modal</h1>
                    </div>
            </div> */}
        </>
    );
};

Index.layout = (page) => <Layout title="Users" children={page} />;
export default Index;
