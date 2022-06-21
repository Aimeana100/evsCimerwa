import { useForm } from "@inertiajs/inertia-react";
import React from "react";
import LoadingButton from "./LoadingButton";

const CreateCompany = () => {
    const { data, setData, errors, post, processing } = useForm({
        Cname: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("companies.store"));
    };

    // const emptyForm = () => {
    //     document.getElementsByName('Cname').addEventListener('change').
    // }
    
    return (
        <div>
            <div className="flex items-center justify-between mb-6 bg-sky-200 p-4 ">
                <form name="createForm" onSubmit={handleSubmit} >
                    <div className="flex flex-column">
                        {/* <label> Company name </label> */}
                        <input
                            className="p-2 min-vw-100 rounded border-2"
                            type="text"
                            name="Cname"
                            erros={errors.Cname}
                            value={data.Cname}
                            onChange={(e) => setData("Cname", e.target.value)}
                            placeholder="Company name"
                        />

                        <LoadingButton
                            loading={processing}
                            type="submit"
                            className="btn-indigo p-2 ml-3 border-none bg-sky-500 rounded-full "
                        >
                            Add Company
                        </LoadingButton>
                    </div>
                    {errors.Cname && <span className="text-red-900 font-200"> {errors.Cname}  </span> }
                </form>
            </div>
        </div>
    );
};

export default CreateCompany;
