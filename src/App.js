import React, { useState, useEffect } from 'react';
import TreeView from './components/tree-view/TreeView';
import './components/tree-view/TreeView.css';
import BodyView from './components/body-view/BodyView';

import axios from "axios";
var treeData = null;
function App() {
  const [initdata, setData] = useState('Initial State');
  const getData = async () => {
    await axios
      .get("http://localhost/treeData.php")
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

  return (

    <div>
      <div style={{ display: "flex" }}>
        {treeData && <TreeView data={treeData} setData={setData} />}
        <div style={{ maxWidth: '800px' }}>
          {initdata && <BodyView data={initdata} />}
        </div>
      </div>
    </div>
  );
}

export default App;