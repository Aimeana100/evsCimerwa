import React, { useState, useEffect, useRef, useReducer, useContext } from "react";
import Input from "@/Components/Input";
import { usePrevious } from "react-use";
import { Label } from "@material-tailwind/react";
import { usePage } from "@inertiajs/inertia-react";
import pickBy from "lodash/pickBy";
import { Inertia } from "@inertiajs/inertia";
import { DataContext, getTapsFiltered } from "@/Layouts/Layout";

const SearchVisitor = () => {
    const { vistors, taps, filters } = usePage().props;
    const {
        data,
        meta: { links },
    } = vistors;

    const {setVisitors} = useContext(DataContext);
    const orderedData = getTapsFiltered(data);


    const [values, setValues] = useState({
        searchFrom: filters.searchFrom || "",
        seachTo: filters.searchTo || "",
        selected: filters.selected || "",
    });

    const prevValues = usePrevious(values);

    useEffect(() => {
        // https://reactjs.org/docs/hooks-faq.html#how-to-get-the-previous-props-or-state
        if (prevValues) {
        //     const query = Object.keys(pickBy(values)).length
        //         ? pickBy(values)
        //         : { remember: "forget" };
        //     Inertia.get(route(route().current()), query, {
        //         replace: true,
        //         preserveState: true,
        //     });

        // console.log(orderedData);


        if(values.selected == "inGate"){
        const visitorIn = orderedData.map((el,index) =>{
            return {...el, records: el.records.filter((elementToFilter) => elementToFilter.status == "IN")}
             
         } );

         setVisitors(visitorIn);
        }

        else if(values.selected == "outGate"){
            const visitorOut = orderedData.map((el,index) =>{
                return {...el, records: el.records.filter((elementToFilter) => elementToFilter.status == "OUT")}
                 
             } );
             setVisitors(visitorOut);
        }

        else {
            setVisitors(orderedData);

        }

        }

    }, [values]);

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;

        setValues((values) => ({
            ...values,
            [key]: value,
        }));
        // if (opened) setOpened(false);
    }


    return (

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
   
   
   );
};

export default SearchVisitor;
