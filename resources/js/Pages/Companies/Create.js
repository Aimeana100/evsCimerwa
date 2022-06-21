import Layout from '@/Layouts/Layout'
import React from 'react'

function Create() {
  return (
    <div className="md:ml-64 pt-10">
      <form >
        <div className='flex flex-column' >
          <label > Company name </label>
          <input className='p-2 min-vw-100' type="text" name='name'  />
        </div>
      </form>
      
    </div>
  )
}
Create.layout = (page)=> <Layout title="Create Company" children={page} />
export default Create
