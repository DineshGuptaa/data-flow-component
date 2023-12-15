import React, { useState, useEffect } from 'react';
import TreeView from './components/tree-view/TreeView';
import './components/tree-view/TreeView.css';
import BodyView from './components/body-view/BodyView'
//import treeData from './components/data/treeData';
import axios from "axios";
var treeData = null;
function App() {
  const [initdata, setData] = useState('initial State');
  const getData = async () => {
    await axios
      .get("http://localhost/treeData.json")//./data.json")
      .then((res) => {
        treeData = res.data;
        setData(treeData);
        console.log("data" + treeData);
      })
      .catch(err => console.log(err))
  }
  useEffect(() => {
    getData()
  }, []);
  //<TreeView data={treeData} setData={setData} />
  return (

    <div>
      <div style={{ display: "flex" }}>
        {treeData && <TreeView data={treeData} setData={setData} />}
        <div style={{ maxWidth: '800px' }}>
          {treeData && <BodyView data={initdata} />}
        </div>
      </div>
    </div>
  );
}

export default App;