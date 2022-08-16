const myList = document.querySelector("#myList");
const friendsList = document.querySelector(".friendsList");
const inputGroup = document.querySelector(".inputGroup");
const itemInput = document.querySelector("#itemInput");
const addBtn = document.querySelector("#addBtn");
let allItems = [];

fetch("index.php?api-name=get-todo")
  .then(async (response) => {
    return await response.json();
  })
  .then(async (data) => {
    if (data) {
      allItems = await data.entries;
    } else {
      allItems = [];
    }
    allItems = allItems.map((el) => el.toString());
    allItems.forEach((item) => addItem(item));
  });

const addItem = (item) => {
  const newItem = document.createElement("li");
  newItem.append(item);
  myList.append(newItem);
  const data = new FormData();
  data.set("newItem", item);
  fetch("index.php?api-name=add-todo", {
    method: "POST",
    body: data,
  });
};

const validateItem = (item) => {
  const allItemsBig = allItems.map((element) => element.toUpperCase());
  if (allItemsBig.includes(item.toUpperCase())) return;
  const firstLetter = item[0];
  const fItem = item.replace(firstLetter, firstLetter.toUpperCase());
  allItems.push(fItem);
  addItem(fItem);
};

const clearInput = () => {
  if (!itemInput.value) {
    itemInput.placeholder = "Add your favorite item:";
    addBtn.hidden = true;
  }
};

inputGroup.addEventListener("submit", (e) => {
  e.preventDefault();
  const itemInput = document.querySelector("#itemInput");
  if (!itemInput.value) return null;
  validateItem(itemInput.value);
  itemInput.value = "";
  clearInput();
});

myList.addEventListener("click", (e) => {
  e.target.nodeName === "LI" && e.target.remove();
  const targetItem = allItems.indexOf(e.target.innerText);
  const data = new FormData();
  data.set("removeItem", e.target.innerText);
  fetch("index.php?api-name=remove-todo", {
    method: "POST",
    body: data,
  });
  allItems.splice(targetItem, 1);
});

inputGroup.addEventListener("focusin", () => {
  itemInput.placeholder = "";
  addBtn.hidden = false;
});

inputGroup.addEventListener("focusout", () => clearInput());
