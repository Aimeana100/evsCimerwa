import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { Head } from "@inertiajs/inertia-react";
import React from "react";

export default function Employees(props) {
    console.log(props);
    return (
        <>
        
            <Sidebar />
            <div className="md:ml-64" >
                Employees
            </div>

          
        </>
    );
}
