import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, useForm, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import React from "react";
import { ClosingAlert, Icon } from "@material-tailwind/react";
import Button from "@/Components/Button";
import LoadingButton from "@/AppComponents/LoadingButton";
import CreateCompany from "@/AppComponents/CreateCompany";

const Index = () => {
    const companies = usePage().props;
    const data = companies.companies.data;
    console.log(data);
    console.log( Boolean(data.length));
    return (
        <>
            <div className="md:ml-64 pt-10">
                <div className="flex align-middle justify-between p-2">
                    <div className="flex">
                        <h1 className="mb-8 text-3xl font-bold">Companies</h1>
                    </div>
                    <CreateCompany />
                    {/* <SearchFilter /> */}
                </div>

                {companies.flash.success && (
                    <ClosingAlert color="teal">
                        {" "}
                        {companies.flash.success}{" "}
                    </ClosingAlert>
                )}

                <div className="overflow-x-auto bg-white rounded shadow">
                    <table className="w-full whitespace-nowrap">
                        <thead>
                            <tr className="font-bold text-left">
                                <th className="px-6 pt-5 pb-4">Title name</th>
                                <th className="px-6 pt-5 pb-4">Status</th>
                                <th className="px-6 pt-5 pb-4">Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            {data.map(({ id, company_name, state }) => {
                                if (Boolean(data.length)) {
                                    return (
                                        <tr
                                            key={id}
                                            className="hover:bg-gray-100 focus-within:bg-gray-100 "
                                        >
                                            <td className="border-t">
                                                {company_name}
                                            </td>
                                            <td className="border-t flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none">
                                                {state ? (
                                                    <div className="bg-[#eeeeee] p-2 translate-x-1 transition-all 2s">
                                                        Actived
                                                    </div>
                                                ) : (
                                                    <div className="bg-[#eeeeee] p-2 backdrop-grayscale-0">
                                                        Banned
                                                    </div>
                                                )}
                                            </td>
                                            <td className="border-t">
                                                {state == true ? (
                                                    <InertiaLink
                                                        href={route(
                                                            "company.burn",
                                                            id
                                                        )}
                                                    >
                                                        <Button> Burn </Button>
                                                    </InertiaLink>
                                                ) : (
                                                    <InertiaLink
                                                        href={route(
                                                            "company.burn",
                                                            id
                                                        )}
                                                    >
                                                        <Button> Awake </Button>
                                                    </InertiaLink>
                                                )}
                                            </td>
                                        </tr>
                                    );
                                }

                                else
                                {

                                
                                    return (
                                        <tr
                                            className="hover:bg-gray-100 focus-within:bg-gray-100 "
                                        > 
                                        <td>
                                            No item
                                        </td>
                                        </tr>
                                    )}
                                
                            
                                
                            })}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
};

Index.layout = (page) => <Layout title="Users" children={page} />;
export default Index;
