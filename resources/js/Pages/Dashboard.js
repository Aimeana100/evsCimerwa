import Sidebar from "@/AppComponents/Sidebar";
import Authenticated from "@/Layouts/Authenticated";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { Head } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import React from "react";
import StatusCard from "@/AppComponents/StatusCard";
// import ChartLine from "@/AppComponents/ChartLine";
// import ChartBar from "@/AppComponents/ChartBar";

const Users = () => {
const prop = usePage().props;

    const {
        users, employees, vistors, companies,last_30days,inInstitution,companiesActive

    } = prop;

    console.log(prop);
    console.log(prop.inInstitution.employee.toString());

    return (
        <>
            <div className="md:ml-64">
            <div className="bg-light-blue-500 px-3 md:px-8 h-40" />

            {/* <div className="px-3 md:px-8 -mt-24">
                <div className="container mx-auto max-w-full">
                    <div className="grid grid-cols-1 xl:grid-cols-5">
                        <div className="xl:col-start-1 xl:col-end-4 px-4 mb-14">
                            <ChartLine />
                        </div>
                        <div className="xl:col-start-4 xl:col-end-6 px-4 mb-14">
                            <ChartBar />
                        </div>
                    </div>
                </div>
            </div> */}



<div className="px-3 md:px-8">
                <div className="container mx-auto max-w-full">
                    <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 mb-4">
                        <StatusCard
                            color="pink"
                            icon="business_center"
                            title="Visitors"
                            amount= {vistors.length.toString()}
                            percentage= { last_30days.vistors.toString() }
                            percentageIcon="arrow_upward"
                            percentageColor="green"
                            date="Since last month"
                        />
                        <StatusCard
                            color="orange"
                            icon="account_circle"
                            title=" Employees"
                            amount={employees.length}
                            percentage= { inInstitution.employee.toString() }
                            percentageIcon="arrow_upward"
                            percentageColor="red"
                            date="In gate"
                        />
                        <StatusCard
                            color="purple"
                            icon="user"
                            title="Users"
                            amount= {users.length.toString()}
                            percentage="-"
                            percentageIcon="arrow_upward"
                            percentageColor="orange"
                            date="Active Users"
                        />
                        <StatusCard
                            color="blue"
                            icon="groups"
                            title="Companies"
                            amount= {companies.length.toString()}
                            percentage={companiesActive}
                            percentageIcon="arrow_upward"
                            percentageColor="green"
                            date="Active Companies"
                        />
                    </div>
                </div>
            </div>
            </div>
        </>
    );
};

Users.layout = (page) => <Layout title="Users" children={page} />;
export default Users;
