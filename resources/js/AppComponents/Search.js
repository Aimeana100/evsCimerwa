import React, { useState, useEffect, useRef } from "react";
import Input from "@/Components/Input";
import { usePrevious } from "react-use";
import { Label } from "@material-tailwind/react";
import { usePage } from "@inertiajs/inertia-react";
import pickBy from "lodash/pickBy";
import { Inertia } from "@inertiajs/inertia";

const Search = () => {
    const { filters } = usePage().props;

    const [values, setValues] = useState({
        search: filters.search || "",
        selected: filters.selected || "",
    });

    const prevValues = usePrevious(values);

    useEffect(() => {
        // https://reactjs.org/docs/hooks-faq.html#how-to-get-the-previous-props-or-state
        if (prevValues) {
            const query = Object.keys(pickBy(values)).length
                ? pickBy(values)
                : { remember: "forget" };
            Inertia.get(route(route().current()), query, {
                replace: true,
                preserveState: true,
            });
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

    console.log(values);

    return (
        <div className="flex justify-between align-baseline flex-lg-row p-2 rounded-md bg-slate-300 w-full ">
            <div className="flex bg-[#dddde7ee] p-2 w-60">
                <Label
                    color="primary"
                    className="bg-[#dcdceeee]  rounded-none px-20 "
                >
                    Filter
                </Label>
                <select
                    value={values.selected}
                    name="selected"
                    onChange={handleChange}
                    className="w-lg-50 p-2 w-full bg-slate-100 border-0  "
                >
                    <option value="" className="w-full p-6">
                        All Employees
                    </option>
                    <option value="banned" className="w-full p-6">
                        Banned
                    </option>
                    <option value="activated" className="w-full p-6">
                        Active
                    </option>
                    <option value="inGate" className="w-full p-6">
                        In-Gate
                    </option>
                </select>
                {/* <Input  /> */}
            </div>

            <div className="flex bg-[#dddde7ee] p-2 flex-1 justify-end self-end">
                <div className="flex w-fit border bg-slate-200 rounded-full py-1 px-3 ">
                    <Label for="search" className="bg-slate-200 px-20 ">
                        Search
                    </Label>

                    <input
                        autoComplete="off"
                        type="text"
                        name="search"
                        value={values.search}
                        onChange={handleChange}
                        className="bg-slate-200 rounded-full"
                    />
                </div>
            </div>
        </div>
    );
};

export default Search;
