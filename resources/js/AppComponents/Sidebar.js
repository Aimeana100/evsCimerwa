import React, { useState } from "react";
import AdminNavbar from "./AdminNavbar";
import H6 from "@material-tailwind/react/Heading6";
import NavLink from "@/Components/NavLink";
import Icon from '@material-tailwind/react/Icon';

function Sidebar({ showSidebar, setShowSidebar }) {
    // const [showSidebar, setShowSidebar] = useState("-left-64");

    return (
        <div>

            <div
                className={`
                h-screen 
                fixed top-0 
                md:left-0 
                ${showSidebar} 
                overflow-y-auto 
                flex-row 
                flex-nowrap 
                overflow-hidden
                shadow-xl 
                bg-white 
                w-64 z-10 
                py-4 px-6 
                transition-all 
                duration-300`}
            >
                <div className="flex-col items-stretch min-h-full flex-nowrap px-0 relative">
                    <a
                        href=""
                        target="_blank"
                        rel="noreferrer"
                        className="mt-2 text-center w-full inline-block"
                    >
                        <H6 color="gray"> E-Vistors </H6>
                    </a>
                    <div className="flex flex-col">
                        <hr className="my-4 min-w-full" />

                        <ul className="flex-col min-w-full flex list-none">
                            <li className="rounded-lg mb-4">
                                <NavLink
                                    href={route("dashboard")}
                                    active={route().current("dashboard")}
                                    activeClassName="bg-gradient-to-tr from-light-blue-500 to-light-blue-700 text-white shadow-md"
                                >
                                    <Icon name="dashboard" size="2xl" />
                                    Dashboard
                                </NavLink>
                            </li>

                            <li className="rounded-lg mb-4">
                                <NavLink
                                    href={route("users")}
                                    active={route().current("users")}

                                    activeClassName="bg-gradient-to-tr from-light-blue-500 to-light-blue-700 text-white shadow-md"
                                >
                                    <Icon name="dashboard" size="2xl" />

                                    Users
                                </NavLink>
                            </li>

                            <li className="rounded-lg mb-4">
                                <NavLink
                                    href={route("vistors")}
                                    active={route().current("vistors")}

                                    activeClassName="bg-gradient-to-tr from-light-blue-500 to-light-blue-700 text-white shadow-md"
                                >
                                    <Icon name="dashboard" size="2xl" />

                                    Vistors
                                </NavLink>
                            </li>

                            <li className="rounded-lg mb-4">
                                <NavLink
                                    href={route("companies")}
                                    active={route().current("companies")}

                                    activeClassName="bg-gradient-to-tr from-light-blue-500 to-light-blue-700 text-white shadow-md"
                                >
                                    <Icon name="dashboard" size="2xl" />
                                    Companies
                                </NavLink>
                            </li>

                            <li className="rounded-lg mb-4">
                                <NavLink
                                    href={route("employees")}
                                    active={route().current("employees")}

                                    activeClassName="bg-gradient-to-tr from-light-blue-500 to-light-blue-700 text-white shadow-md"
                                >
                                    <Icon name="dashboard" size="2xl" />
                                    Employees
                                </NavLink>
                            </li>


                            <li className="rounded-lg mb-4">
                                <NavLink
                                    href={route("equipments")}
                                    active={route().current("equipments")}

                                    activeClassName="bg-gradient-to-tr from-light-blue-500 to-light-blue-700 text-white shadow-md"
                                >
                                    <Icon name="dashboard" size="2xl" />
                                    Equipments
                                </NavLink>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Sidebar;
