import React, { useState } from "react";
import H6 from "@material-tailwind/react/Heading6";
import NavLink from "@/Components/NavLink";
import Icon from "@material-tailwind/react/Icon";
import Sidebar from "@/AppComponents/Sidebar";
import AdminNavbar from "@/AppComponents/AdminNavbar";

function Layout({ title, children }) {
    const [showSidebar, setShowSidebar] = useState("-left-64");

    return (
        <div>
            <AdminNavbar
                showSidebar={showSidebar}
                setShowSidebar={setShowSidebar}
            />
            <Sidebar
                showSidebar={showSidebar}
                setShowSidebar={setShowSidebar}
            />
            <div className="mx-1 p-2">{children}</div>
        </div>
    );
}

export default Layout;
