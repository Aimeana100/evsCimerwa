import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import React from "react";
import { Button, ClosingAlert, Icon } from "@material-tailwind/react";
import Search from "@/AppComponents/Search";
// import SearchFilter from "@/AppComponents/SearchFilter";

const Index = () => {
    const employees = usePage().props;
    console.log(employees);

    const { data, meta: links } =  employees.employees;

    return (
        <>
            <div className="md:ml-64 pt-10">
                <h1 className="mb-8 text-3xl font-bold">Employees</h1>
                <div className="flex items-center w-full justify-between mb-6">
                    <Search />

                    {/* <SearchFilter /> */}
                </div>

                {employees.flash.success && (
                    <ClosingAlert color="teal">

                        {employees.flash.success}
                    </ClosingAlert>
                )}

                <div className="overflow-x-auto bg-white rounded shadow">
                    <table className="w-full whitespace-nowrap">
                        <thead>
                            <tr className="font-bold text-left">
                                <th className="px-6 pt-5 pb-4">Names</th>
                                <th className="px-6 pt-5 pb-4">ID card</th>
                                <th className="px-6 pt-5 pb-4">Telphone</th>
                                <th className="px-6 pt-5 pb-4">Gender</th>
                                <th className="px-6 pt-5 pb-4">Category</th>
                                <th className="px-6 pt-5 pb-4">State </th>
                                <th className="px-6 pt-5 pb-4">Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            {data.map(
                                ({
                                    id,
                                    names,
                                    phone,
                                    ID_Card,
                                    gender,
                                    state,
                                    category,
                                }) => {
                                    return (
                                        <tr
                                            key={id}
                                            className="hover:bg-gray-100 {'bg-red-200' || state == true} focus-within:bg-gray-100"
                                        >
                                            <td className="border-t">
                                                {names}
                                            </td>
                                            <td className="border-t flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none">
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
                                            <td className="border-t">
                                                {state == true
                                                    ? "Activeted"
                                                    : "burned"}
                                            </td>
                                            <td className="border-t">
                                                {state == true ? (
                                                    <InertiaLink
                                                        href={route(
                                                            "employee.burn",
                                                            id
                                                        )}
                                                    >
                                                        <Button> Burn </Button>
                                                    </InertiaLink>
                                                ) : (
                                                    <InertiaLink
                                                        href={route(
                                                            "employee.burn",
                                                            id
                                                        )}
                                                    >
                                                        <Button> Revoke </Button>
                                                    </InertiaLink>
                                                )}
                                            </td>
                                        </tr>
                                    );
                                }
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
};

Index.layout = (page) => <Layout title="Users" children={page} />;
export default Index;
