import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import React, { Component } from "react";
import { Icon } from "@material-tailwind/react";
import SearchVisitor from "@/AppComponents/SearchVisitor";
import { create, isArray } from "lodash";
// import TableRow from "@/AppComponents/TableRow";
// import Search from "@/AppComponents/Search";

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
            "Date",
        ];
        return (
            <div>
                <Table tableTitle={tableTitle} heading={heading} body={body} />
            </div>
        );
    }
}

class Table extends Component {
    render() {
        var heading = this.props.heading;
        var body = this.props.body;
        var title = this.props.tableTitle;

        return (
            <div className="overflow-x-auto bg-white rounded shadow border-2">
                <h1 className="text-center px-6"> {title} </h1>

                <table className="w-full whitespace-nowrap mb-3 mx-2 pb-4">
                    <thead>
                        <tr className="font-bold text-left">
                            {heading.map((head, key) => (
                                <th key={key}>{head}</th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {body.map((row, key) => (
                            <TableRow key={key} row={row} />
                        ))}
                    </tbody>
                </table>
            </div>
        );
    }
}

class TableRow extends Component {
    render() {
        var row = this.props.row;
        function containsSpecialChars(str) {
            const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
              return specialChars.test(str);

          }

          const calculateTimeIN = tp =>{
              var timerange= 0;

             return tp.map((item,index) =>{
                  return [item.tapped_at, item.status, item];
              }).sort();

              tp.forEach((item, index,arr) =>
              {
                 arr.length >= 2 && console.log(item, arr.length , item.ID_Card);
                 
              })
          }

         console.log(calculateTimeIN(row.taps)) ;


        return (

            
            <tr className="hover:bg-gray-100 focus-within:bg-gray-100 py-2">
                <td className="border-t text-[12px]">{row.id}</td>
                <td className="border-t text-[12px]">{row.names}</td>
                <td className="border-t text-[12px]">
                    {(!containsSpecialChars(row.phone) ) && row.phone}
                </td>
                <td className="border-t text-[12px]">{row.ID_Card}</td>
                <td className="border-t text-[12px]">{row.gender}</td>
                <td className="border-t text-[12px]">
                    <Taps taps={row.taps} />
                  
                </td>
                <td className="border-t text-[12px]">{row.stutus}</td>
            </tr>
        );
    }
}

class TapsRow extends Component {
    render() {
        var rows = this.props.taprow;
        const { ENTERING, EXITING } = rows;

        // console.log(EXITING);

        const getL = dt =>{

        const { ENTERING, EXITING } = dt;

        if(typeof ENTERING == "undefined"){
            return EXITING;
        }
        else if(typeof EXITING == "undefined"){
            return ENTERING;
        }
        else{
            return ENTERING.length > EXITING.length ? ENTERING : EXITING;

        }


        }

        var largeArr = getL(rows);


        return (
            largeArr.map((item, index) => {
                return (
                    <tr className="relative" key={index}>

                    {typeof ENTERING != "undefined" &&
                                typeof ENTERING[index] &&
                        
                        <td className="relative bg-zinc-200  border border-red-100 rounded-2 bg-gradient-to-r from-zinc-200 to-zinc-400 ">
                           
                           <span className="relative pr-1 text-[11px]">
                                <span className="absolute rounded-full w-[5px] h-[5px] mx-1  bg-blue-700 -right-1 -top-[1/2]" ></span>
                                {ENTERING[index]}  
                            </span>
                            
                        </td>
            }

                        {typeof EXITING != "undefined" &&
                                typeof EXITING[index] &&

                        <td className="relative ml-1 bg-gradient-to-r  from-blue-300 to-blue-100">
                           <span className="relative pr-1 text-[11px]">
                           <span className="absolute rounded-full w-[5px] h-[5px] mx-1  bg-green-700 -right-1 -bottom-1" ></span>
                                
                            
                                {EXITING[index]}
                           </span>
                        </td>
                        }
                    </tr>
                );
            })
        );
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

        var neObj = taps.reduce((prv, curr) => {
            var key = curr.status;
            if (!prv[key]) {
                prv[key] = [];
            }

            prv[key].push(createDateString(curr.tapped_at));
            return prv;
        }, {});

        // console.log(taps.length);

        const { ENTERING, EXITING } = neObj;

        // console.log(ENTERING.length);

        // if(ENTERING == undefined){
        //     console.log(taps);
        //     return ENTERING;
        // }

        // var newO = Object.entries(neObj).reduce((acc, item)=>{
        //     console.log(neObj);
        //     console.log("new");
        // });
        console.log(neObj.ENTERING, neObj.EXITING);

        return (
            <table>
                <tbody className="grid grid-cols-1 divide-red-800 divide-y">
                    {/* { neObj.map(({ENTERING,EXITING}) => {
                    var minutes = createDateString(item.tapped_at);

                    return (()=>{
                        console.log(1);
                    })  ;
                })} */}

                    <TapsRow taprow={neObj} />
                    {/* <tr><td> h </td> <td> h </td>  </tr>
                <tr><td> h </td> </tr> */}

                </tbody>
            </table>
        );
    }
}

const Index = () => {
    const { vistors, taps } = usePage().props;

    const {
        data,
        meta: { links },
    } = vistors;

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

    var createDateString = (dates) => {
        var dates =
            new Date(dates).getFullYear() +
            "-" +
            (parseInt(new Date(dates).getMonth()) + 1) +
            "-" +
            new Date(dates).getDate();

        return dates;
    };

    var date1 =  new Date('2022-05-30T13:35:48');
    var date2 =  new Date('2022-05-30 13:55:48');

    // console.log(date1.toDateString());

    var taps_filtered = [];

    var organized = organizeDaily(data);

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

    // console.log(taps_filtered);

    var dateCombined = "";
    var Rspans = 0;
    var renderFlag = false;

    return (
        <>
            <div className="md:ml-64 pt-10">
                <h1 className="mb-8 text-3xl font-bold">Vistors</h1>
                <div className="flex items-center justify-between mb-6">
                    <div className="flex items-center w-full justify-between mb-6">
                        <SearchVisitor />
                    </div>
                </div>

                {taps_filtered.map((item, index, arr) => {
                    // console.log(item.records);
                    return (
                        <TableComponent
                            data={item.records}
                            tableTitle={item.date}
                        />
                    );
                })}
            </div>
        </>
    );
};

Index.layout = (page) => <Layout title="Users" children={page} />;
export default Index;
