import React, { useState, useEffect, useRef } from "react";
import Input from "@/Components/Input";
import { usePrevious } from "react-use";
import { Label } from "@material-tailwind/react";
import { usePage } from "@inertiajs/inertia-react";
import pickBy from "lodash/pickBy";
import { Inertia } from "@inertiajs/inertia";

const EmpAttendanceSearch = () => {
    const { filters } = usePage().props;

    const [values, setValues] = useState({
        search: filters.search || "",
        selected: filters.selected || "",
        onDate: filters.onDate || "",
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

    // console.log(values);

    return (

    );
};

export default EmpAttendanceSearch;
