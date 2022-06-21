import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import React from "react";
import { Icon } from "@material-tailwind/react";

const Index = () => {
    const { users } = usePage().props;

    console.log(users);

    // const {
    //   data,
    //   meta: { links }
    // } = users;

    return (
        <>
            <div className="md:ml-64 pt-10">
                <h1 className="mb-8 text-3xl font-bold">Users</h1>
                <div className="flex items-center justify-between mb-6">
                    {/* <SearchFilter /> */}

                    <InertiaLink
                        className="btn-indigo focus:outline-none"
                        href={route("users.create")}
                    >
                        <span>Create</span>
                        <span className="hidden md:inline"> User</span>
                    </InertiaLink>
                </div>

                <div className="overflow-x-auto bg-white rounded shadow">
                    <table className="w-full whitespace-nowrap">
                        <thead>
                            <tr className="font-bold text-left">
                                <th className="px-6 pt-5 pb-4">Names</th>
                                <th className="px-6 pt-5 pb-4">Email</th>
                                <th className="px-6 pt-5 pb-4">NID</th>
                            </tr>
                        </thead>
                        <tbody>
                            {users.map(({ id, name, NID, email }) => {
                                return (
                                    <tr
                                        key={id}
                                        className="hover:bg-gray-100 focus-within:bg-gray-100"
                                    >
                                        <td className="border-t">
                                            <InertiaLink
                                                href={route("users.edit", id)}
                                                className="flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none"
                                            >
                                                    {/* {photo && (
                                                    <img
                                                    src={photo}
                                                    className="block w-5 h-5 mr-2 -my-2 rounded-full"
                                                    />
                                                )} */}

                                                {name}
                                                {/* {deleted_at && (
                                                <Icon
                                                name="trash"
                                                className="flex-shrink-0 w-3 h-3 ml-2 text-gray-400 fill-current"
                                                />
                                            )} */}
                                            
                                            </InertiaLink>
                                        </td>
                                        <td className="border-t">
                                            <InertiaLink
                                                tabIndex="-1"
                                                href={route("users.edit", id)}
                                                className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                            >
                                                {email}
                                            </InertiaLink>
                                        </td>
                                        <td className="border-t">
                                            <InertiaLink
                                                tabIndex="-1"
                                                href={route("users.edit", id)}
                                                className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                            >
                                                {NID}
                                            </InertiaLink>
                                        </td>
                                     
                                    </tr>
                                );
                            })}
                            {users.length === 0 && (
                                <tr>
                                    <td
                                        className="px-6 py-4 border-t"
                                        colSpan="4"
                                    >
                                        No users found.
                                    </td>
                                </tr>
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
